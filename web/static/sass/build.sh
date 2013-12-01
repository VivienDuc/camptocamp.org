# shortcut to build css file with sass

set -e # exit on error

# delete obsolete css files
#for i in `ls ../css | grep '\.css$'`; do
#  if [ ! -f ${i%css}scss ]; then
#    rm -f ../css/$i
#  fi
#done

# delete all css files
# we want to be sure that they are up-to-date
# even if referred images changed
rm -f ../css/*.css

# compile stylesheets
compass compile
