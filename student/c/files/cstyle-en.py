#! /usr/bin/python3
import sys
import re


message = ""
if len(sys.argv) != 2:
    print("incorrect run args: python3 cstyle.py prog.c")
    sys.exit(1)
with open(sys.argv[1], 'r') as in_file:
    bracket_level = 0
    indent_level = 0
    index = 0
    previous_line = ""
    wait_brace = False
    main_return = False
    for line in in_file:
        index += 1
        real_line = line
        indent_level -= line.count('}')
        preline = "----------------\n"
        preline += "Ошибка стиля на " + str(index) + "-й строке:\n"
        preline += line[:-1] + "\n"

#        if "\t" in line:
#            message += preline + "replace tabulation by 4 spaces\n\n";
        line = line.replace("\t", "    ")

        if line.strip()[0:2] == "//":
            continue

        # clean comment
        line = re.sub("\s*//.+", "", line);

        # include
        if '#include' in line:
            if re.match('#include <[\w\.]+>\n', line):
                index += 1
                indent_level += line.count('{')
                continue
            else:
                message += preline + "#include directive: '#include <stdio.h>\n\n"

        # clean constant string
        line = re.sub("\".+\"", "\"\"", line);
        line = re.sub("'.+'", "''", line);
  
        # spaces
        if re.search("\s\n", line):
            message += preline + "Remove spaces at the end of line\n\n"
        if re.search(",[^ ]", line):
            message += preline + "Append one space after ','\n\n"
        if re.search(" ,", line):
            message += preline + "Remove the space before ','\n\n"
        if re.search(" ;", line):
            message += preline + "Remove the space before ';'\n\n"
        if re.search("\( ", line):
            message += preline + "Remove the space before '('\n\n"
        if re.search(" \)", line):
            message += preline + "Remove the space before ')'\n\n"
        if re.search("{[^\n]", line):
            message += preline + "Append newline after '{'\n\n"
        if " for(" in line or " for (" in line:
            if not re.search("for \([^;]*; [^;]*; [^)]*\)( {)?", line):
                message += preline + "Spaces in 'for' loop: 'for (start; condition; post)'\n\n"
        else:
            if re.search(";[^\n]", line):
                message += preline + "Append newline after ';'\n\n"
        if "}" in line:
            if re.search("}( else| while|;)", line) is None:
                if re.search("}[^\n]", line):
                    message += preline + "Append newline after '}' (exceptions: '} else', '} while' or '};') \n\n"
 
        # binary
        bin_ops = [ '\+', '\-', '\*', '/', '%',
                          '>', '<', '==', '>=', '<=', '!=',
                          '&&', '\|\|',
                          '\|', '\^',
                          '>>', '<<']
        left_operand = "([A-Za-z0-9\)'\"\]])"
        right_operand = "([A-Za-z0-9\(\*&'\"])"
        for op in bin_ops:
            if re.search(left_operand + op + "\s*?" + right_operand, line):
                message += preline + "Append space before binary operation " + op + "\n\n"
            if re.search(left_operand + "\s*?" + op + right_operand, line):
                message += preline + "Append space after binary operation " + op + "\n\n"

        for op in bin_ops:
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)

        # binary
        bin_ops = ['\+=', '\-=', '\*=', '/=', '%=', '=', '>>=', '<<=', '\|=', '\^=', '&=' ]
        left_operand = "([A-Za-z0-9\)\]])"
        right_operand = "([A-Za-z0-9\(\*&'\"\+\-])"
        for op in bin_ops:
            if re.search(left_operand + op + "\s*?" + right_operand, line):
                message += preline + "Append space before binary operation " + op + "\n\n"
            if re.search(left_operand + "\s*?" + op + right_operand, line):
                message += preline + "Append space after binary operation " + op + "\n\n"

        for op in bin_ops:
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)

        # pre unary ++ -- + - * &
        pre_ops = [ '\+\+', '\-\-', '\+', '\-', '\*', '&']
        for op in pre_ops:
            if re.search(op + "\s+?" + right_operand, line):
                message += preline + "Remove the space after unary  " + op + "\n\n"
        for op in pre_ops:
            line = re.sub(op + "\s+?" + right_operand, r"@ \1", line)

        # post ++ --
        post_ops = [ '\+\+', '\-\-' ]
        for op in post_ops:
            if re.search(left_operand + "\s+?" + op, line):
                message += preline + "Remove the space before unary " + op + "\n\n"
        for op in post_ops:
            line = re.sub(left_operand + "\s+?" + op, r"\1 @", line)


        # indent

        print("{:3}".format(index), indent_level, real_line[:-1])

        if wait_brace:
            if "{" not in line:
                message += preline + "Append '{' brace after operator: if else while do for ... \n\n";
            wait_brace = False

        keywords = [ 'if', 'else', 'do', 'for' ]
        for key in keywords:
            if re.search(" " + key + "[^A-Za-z0-9_]", line):
                wait_brace = True

        if re.search(' while [^A-Za-z0-9_]', line):
            if ';' != line.strip()[-1]:
                wait_brace = True

        if "{" in line:
            wait_brace = False

        if bracket_level == 0:
            if re.match("    " * indent_level + "[^ ]", line) is None:
                message += preline + "Shift indent to " + str(indent_level) + " level\n\n";


        previous_line = line
        indent_level += line.count('{')
        bracket_level += line.count('(')
        bracket_level -= line.count(')')

        if "return 0" in line:
            main_return = True
    if not main_return:
        message += preline + "Append 'return 0;' at the end of main() \n\n";

    if message:
         sys.stderr.write(message)
         sys.exit(-1)
