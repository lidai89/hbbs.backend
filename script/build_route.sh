#!/bin/bash

serverdir=server
out_file=HandlerRouter.php

tmp_file=/tmp/$out_file

function error_exit
{
    ## do clean up
    rm -rf $tmp_file

    ## print error message
    echo "Error: $1"
    exit 1;
} 1>&2

if [[ ! -d $serverdir/handler ]]; then
    error_exit "no handler directory found in $PWD/server"
fi

rm -rf $tmp_file || error_exit "failed to initialize $tmp_file"

cat > $tmp_file <<'EOF'
<?php declare(strict_types=1);

/**
 * DO NOT EDIT
 * generated by script/build_route.sh
 */

namespace site;

class HandlerRouter
{
    public static $route = [
EOF

{
cd $serverdir
for i in `find handler -name 'Handler.php'`; do
    uri=$(dirname $i | cut -c 9-)
    handler=$(echo $i | sed 's/.php$//')
    echo \'$uri\'' => '\''site\'$(echo $handler | sed 's!/!\\!g')\'','
done | sort -t \' -k 2,2
} | column -t | sed 's/^/        /' >> $tmp_file

cat >> $tmp_file <<'EOF'
    ];
}
EOF

if [[ ! -f $serverdir/$out_file ]]; then
    mv -f $tmp_file $serverdir/$out_file
else
    if [[ ! -z "$(diff $tmp_file $serverdir/$out_file || echo 'Failed to diff')" ]]; then
        mv -f $serverdir/$out_file $serverdir/$out_file.backup && mv -f $tmp_file $serverdir/$out_file
    else
        echo "$out_file file not changed, skip updating"
        rm -rf $tmp_file
    fi
fi
