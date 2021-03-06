#!/bin/bash

status=0
common="$(dirname "${BASH_SOURCE[0]}")/common.source.sh"
if [[ ! -f $common ]]; then
    status=1
else
    source $(dirname "${BASH_SOURCE[0]}")/common.source.sh || status=2
fi

if [[ $status > 0 ]]; then
    echo 'failed to load source file, aborted' 1>&2;
    exit $status
fi

file_dir=/home/web/www.houstonbbs.com/client

tmp_list=/tmp/files_deleted.list
mysql -D hbbs -e 'SELECT id, path FROM images_deleted' > $tmp_list || error_exit 'failed to get file list from database'

fids=''
paths=''

while read line; do
    fids="$fids, $(echo $line | awk '{print $1}')"
    paths="$paths $file_dir$(echo $line | awk '{print $2}')"
done < <(tail -n +2 $tmp_list) ## use process substitution, do not use pipe because it will create a subshell for while loop

if [[ ! -z $fids ]]; then
    rm -rf $paths || error_exit "failed to delete files: $paths"
    fids=$(echo $fids | sed 's/^, //')
    mysql -D hbbs -e "DELETE FROM images_deleted WHERE id IN ($fids)" || error_exit "failed to update database for fids: '$fids'"
fi

count=$(wc -l $tmp_list | awk '{print $1}')
if [[ $count > 1 ]]; then
    count=$(expr $count - 1)
    echo "cleaned $count files"
fi

rm -rf $tmp_list
