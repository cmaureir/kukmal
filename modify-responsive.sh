#!/bin/bash

# 1. Home button Blue to Green
sed 's/blue\ button/green\ button/' -i ../home.php || echo "Error: sed to change blue button";

# 2. Adding JavaScript and CSS files to the header of the theme
header="<!-- KuKmal style -->\n\
<link rel=\"stylesheet\" href=\"<?php echo get_template_directory_uri(); ?>\/kukmal\/css\/kukmalstyle.css\">\n\
<script src=\"<?php echo get_template_directory_uri(); ?>\/kukmal\/js\/kukmal-jquery.min.js\"><\/script>\n\
<script src=\"<?php echo get_template_directory_uri(); ?>\/kukmal\/js\/kukmal.js\"><\/script>\n\
<!-- END KuKmal style -->\n"
line="<\/head>"

# The following line will replace the first 'match' of the value of $line
# and then will replace 'before' that line the content in $header
sed "s/\($line\)/$header\1/" -i ../header.php || echo "Error: adding lines to header";

# 3. Adding kukmal functions file to functions.php
echo "\nrequire ( get_template_directory() . '/kukmal/kukmalfunctions.php' );" >> ../functions.php || echo "Error: Adding functions file to functions.php";

#. 4 Adding the table function to the 'single-post' template
line="<?php the_content(__('Read more &#8250;', 'responsive')); ?>"
table="<?php include('kukmal/kukmaltable.php'); ?>"

# The following line will 'match' $line, and the symbol 'a\'
# will leave the same text, but will add the content in a new line
# so we will insert a newline and then the content of $table
sed "/\(${line}\)/ a\ \t\t$table" -i ../single.php || echo "Error: Error adding table";

# 5. Removing sidebar of the single posts display
sed 's/<?php get_sidebar(); ?>//g' -i single.php || echo "Error: removing sidebar"

# DO NOT UNCOMMENT THIS SECTION
# Still in progress
## 6. Modifying the 'single.php' content
## Backup the original single.php
#cp ../single.php single.php.bak || echo "Error: Copying single.php"
## Renaming the single.php
#mv ../single.php ../single_blog.php || echo "Error: Moving single.php to single_blog.php"
## Updating the single.php with our file
#cp kukmal_single_comments.php ../single.php || echo "Error: Copying our template without comments"


# Modifying Green
sed 's/4bc380/c7c706/g' -i ../style.css || echo "Error: Modifying colors"
sed 's/2e8b57/A6A605/g' -i ../style.css || echo "Error: Modifying colors"
sed 's/71d09b/cdcd06/g' -i ../style.css || echo "Error: Modifying colors"
# New green
sed 's/A6A605/8F8F04/g' -i ../style.css || echo "Error: Modifying colors"

# Green links
sed 's/color:\ #06c;/color:\ #A6A605;/g' -i ../style.css || echo "Error: Modifying green links"
