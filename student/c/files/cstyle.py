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
    index = 1
    previous_line = ""
    for line in in_file:
        indent_level -= line.count('}')
        preline = "----------------\n"
        preline += "line " + str(index) + ":\n"
        preline += line[:-1] + "\n"
        preline += "codestyle error: "

        # clean comment
        line = re.sub("\s*//.+", "", line);

        # include
        if '#include' in line:
            if re.match('#include <[\w\.]+>\n', line):
                index += 1
                indent_level += line.count('{')
                continue
            else:
                message += preline + "include line format is '#include <stdio.h>\n\n"

        # clean constant string
        line = re.sub("\".+\"", "", line);

        # spaces
        if re.search("\s\n", line):
            message += preline + "no space at the end of line\n\n"
        if re.search(",[^ ]", line):
            message += preline + "space after ','\n\n"
        if re.search(" ,", line):
            message += preline + "no space before ','\n\n"
        if re.search("{[^\n]", line):
            message += preline + "newline after '{'\n\n"
        if re.search("for", line):
            if not re.match("    for \([^;]*?; [^;]*?; [^)]*?\)( {)?\n", line):
                message += preline + "space in cycle 'for': 'for (start; condition; post)'\n\n"
        else:
            if re.search(";[^\n]", line):
                message += preline + "newline after ';'\n\n"
        if "}" in line:
            if re.search("}( else| while|;)", line) is None:
                if re.search("}[^\n]", line):
                    message += preline + "no text after } except '} else', '} while' or '};' \n\n"
 
        # binary
        bin_ops = [ '\+', '\-', '\*', '/', '%',
                          '>', '<', '==', '>=', '<=', '!=',
                          '&&', '\|\|',
                          '&', '\|',
                          '\+=', '\-=', '\*=', '/=', '%='
                          '>>', '<<',
                          '>>=', '<<=']
        left_operand = "([A-Za-z0-9\)])"
        right_operand = "([A-Za-z0-9\(])"
        for op in bin_ops:
            if re.search(left_operand + op + "\s*?" + right_operand, line):
                message += preline + "space in the left of binary " + op + "\n\n"
            if re.search(left_operand + "\s*?" + op + right_operand, line):
                message += preline + "space in the right of binary " + op + "\n\n"

        for op in bin_ops:
            line = re.sub(left_operand + "\s*?" + op + "\s*?" + right_operand, r"\1 @ \2", line)
            line = re.sub(left_operand + "\s*?" + op + "\s*?" + right_operand, r"\1 @ \2", line)

        # pre unary ++ -- + - * &
        pre_ops = [ '\+\+', '\-\-', '\+', '\-', '\*', '&']
        for op in pre_ops:
            if re.search(op + "\s+?" + right_operand, line):
                message += preline + "space in the right of pre-unary " + op + "\n\n"
        for op in pre_ops:
            line = re.sub(op + "\s+?" + right_operand, r"@ \1", line)

        # post ++ --
        post_ops = [ '\+\+', '\-\-' ]
        for op in post_ops:
            if re.search(left_operand + "\s+?" + op, line):
                message += preline + "space in the right of post-unary " + op + "\n\n"
        for op in post_ops:
            line = re.sub(left_operand + "\s+?" + op, r"\1 @", line)


        # indent
        if "\t" in line:
            message += preline + "replace tabulation by 4 spaces\n\n";
        mini_level = 0
        if ('if' in previous_line) or ('else' in previous_line) or ('while' in previous_line) or ('for' in previous_line):
            if '{' not in previous_line and previous_line[-2] != ';':
                mini_level = 1

        if bracket_level == 0:
            if re.match("    " * (indent_level + mini_level) + "[^ ]", line) is None:
                print(indent_level, mini_level)
                message += preline + "indent in " + str(indent_level) + " indent level\n\n";


        previous_line = line
        index += 1
        indent_level += line.count('{')
        bracket_level += line.count('(')
        bracket_level -= line.count(')')
    if message:
         sys.stderr.write(message)
         sys.exit(-1)
