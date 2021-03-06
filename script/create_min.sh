function min
{
  type=$1;
  target=$2;
  time=$3;
  java -jar /home/web/yuicompressor-2.4.7/build/yuicompressor-2.4.7.jar -v --type $type --charset utf-8 -o $type/min${target}_$time.$type $type/all${target}_$time.$type >> min_$time.log 2>&1;
}

time=`date +%s`;

target='pc'
list=`cat <<EOD
js/cookie.js
js/jquery-1.8.3.js
js/jquery.upload-1.0.2.js
js/jquery.markitup.js
js/jquery.markitup.bbcode.set.js
js/superfish.js
js/coin-slider.js
js/jquery.MetaData.js
js/jquery.rating.js
js/main.js
EOD`
cat `echo $list | tr '\n' ' '` > js/all${target}_$time.js
min js $target $time;

list=`cat <<EOD
css/default.css
css/system.css
css/houstonbbs.css
css/html-elements.css
css/advanced_forum.css
css/advanced_forum-structure.css
css/superfish.css
css/markitup.style.css
css/markitup.bbcode.css
css/coin-slider-styles.css
css/yp.css
css/jquery.rating.css
css/privatemsg-view.css
EOD`
cat `echo $list | tr '\n' ' '` > css/all${target}_$time.css
min css $target $time;

target='mb' #mobile phone
list=`cat <<EOD
js/cookie.js
js/jquery-1.8.3.js
js/jquery.upload-1.0.2.js
js/jquery.markitup.js
js/jquery.markitup.bbcode.set.js
js/superfish.js
js/coin-slider.js
js/jquery.MetaData.js
js/jquery.rating.js
js/main.js
EOD`
cat `echo $list | tr '\n' ' '` > js/all${target}_$time.js
min js $target $time;

list=`cat <<EOD
css/default.css
css/system.css
css/houstonbbs.css
css/html-elements.css
css/markitup.style.css
css/markitup.bbcode.css
EOD`
cat `echo $list | tr '\n' ' '` > css/all${target}_$time.css
min css $target $time;

sleep 1;
# gzip css and js min file
for i in `ls */min*_$time.*s`; do
	gzip -c $i > $i.gz;
done
