if (( $# == 1 ))
then
    file=$1
    cat $file | sed 's/\t/    /g' > $file
else
    echo "bash tab2space.sh file.c"
fi
