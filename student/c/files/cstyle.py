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
                message += preline + "Директива #include должна выглядеть так: '#include <stdio.h>\n\n"

        # clean constant string
        line = re.sub("\".+\"", "\"\"", line);
        line = re.sub("'.+'", "''", line);
  
        # spaces
        if re.search("\s\n", line):
            message += preline + "Убрать пробелы в конце строки\n\n"
        if re.search(",[^ ]", line):
            message += preline + "Добавить пробел после ','\n\n"
        if re.search(" ,", line):
            message += preline + "Убрать пробел перед ','\n\n"
        if re.search(" ;", line):
            message += preline + "Убрать пробел перед ';'\n\n"
        if re.search("\( ", line):
            message += preline + "Убрать пробел после '('\n\n"
        if re.search(" \)", line):
            message += preline + "Убрать пробел перед ')'\n\n"
        if re.search("{[^\n]", line):
            message += preline + "Добавить перенос на новую строку после '{'\n\n"
        if " for(" in line or " for (" in line:
            if not re.search("for \([^;]*; [^;]*; [^)]*\)( {)?", line):
                message += preline + "Пробелы в цикле 'for': 'for (start; condition; post)'\n\n"
        else:
            if re.search(";[^\n]", line):
                message += preline + "Добавить перенос на новую строку после ';'\n\n"
        if "}" in line:
            if re.search("}( else| while|;)", line) is None:
                if re.search("}[^\n]", line):
                    message += preline + "Добавить перенос на новую строку после '}' (исключения: '} else', '} while' or '};') \n\n"
 
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
                message += preline + "Добавить пробел перед бинарным оператором " + op + "\n\n"
            if re.search(left_operand + "\s*?" + op + right_operand, line):
                message += preline + "Добавить пробел после бинарного оператора " + op + "\n\n"

        for op in bin_ops:
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)

        # binary
        bin_ops = ['\+=', '\-=', '\*=', '/=', '%=', '=', '>>=', '<<=', '\|=', '\^=', '&=' ]
        left_operand = "([A-Za-z0-9\)\]])"
        right_operand = "([A-Za-z0-9\(\*&'\"\+\-])"
        for op in bin_ops:
            if re.search(left_operand + op + "\s*?" + right_operand, line):
                message += preline + "Добавить пробел перед бинарным оператором " + op + "\n\n"
            if re.search(left_operand + "\s*?" + op + right_operand, line):
                message += preline + "Добавить пробел после бинарного оператора " + op + "\n\n"

        for op in bin_ops:
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)
            line = re.sub(left_operand + "\s?" + op + "\s?" + right_operand, r"\1 @ \2", line)

        # pre unary ++ -- + - * &
        pre_ops = [ '\+\+', '\-\-', '\+', '\-', '\*', '&']
        for op in pre_ops:
            if re.search(op + "\s+?" + right_operand, line):
                message += preline + "Убрать пробел после унарного оператора " + op + "\n\n"
        for op in pre_ops:
            line = re.sub(op + "\s+?" + right_operand, r"@ \1", line)

        # post ++ --
        post_ops = [ '\+\+', '\-\-' ]
        for op in post_ops:
            if re.search(left_operand + "\s+?" + op, line):
                message += preline + "Убрать пробел перед унарным оператором " + op + "\n\n"
        for op in post_ops:
            line = re.sub(left_operand + "\s+?" + op, r"\1 @", line)


        # indent

        print("{:3}".format(index), indent_level, real_line[:-1])

        if wait_brace:
            if "{" not in line:
                message += preline + "Добавить скобку '{' после оператора: if else while do for ... \n\n";
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
                message += preline + "Выровнить отступ на " + str(indent_level) + "-й уровень\n\n";


        previous_line = line
        indent_level += line.count('{')
        bracket_level += line.count('(')
        bracket_level -= line.count(')')

        if "return 0" in line:
            main_return = True
    if not main_return:
        message += preline + "Добавить строку 'return 0;' в конце main() \n\n";

    if message:
         sys.stderr.write(message)
         sys.exit(-1)
