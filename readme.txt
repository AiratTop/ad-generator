=== Ad Generator ===  
Contributors: Airat Halitov  
Requires at least: 3.8  
Tested up to: 5.6  
Stable tag: 2.2.0  
License: GPLv3  
License URI: https://www.gnu.org/licenses/gpl-3.0.html  

Professional text randomizer and ad generator.

== Description ==

Professional text randomizer and ad generator for classifieds.

== Installation ==

1. Go to 'Plugins > Add New'  
2. Click 'Upload Plugin'  
3. Upload the 'ad-generator.zip' file  
4. Activate Ad Generator from the Plugins page  
5. Add the `[ad_generator]` shortcode to a WordPress page

= Configuration =

1. Create a new WordPress page, insert the `[ad_generator]` shortcode and save  
2. Open the page and use the ad generator  
3. Enjoy!

== Changelog ==

= 2.2.0 =  
* Fixed bug with extra space replacements  
* Refactored randomizer code  
* Added more template examples

= 2.0.1 =  
* Fixed bug with unexpected extra spaces (#12)

= 2.0.0 =  
* Added new CLI version  
* CLI error handling and help added  
* Added label tags to option selection  
* Fixed trimming of extra spaces in output

= 1.4.0 =  
* Increased max character count from 4000 to 10000  
* Fixed autofocus issue on form page

= 1.3.2 =  
* Added IDs to result count selectors  
* Updated license URL  
* Added screenshots to README.md  
* Updated GitHub files (DOCUMENTATION, ISSUE_TEMPLATE, README)  
* Renamed Ad-Generator → ad-generator  
* Updated translation files

= 1.3.1 =  
* Output formatting improvements  
* Updated translations

= 1.3.0 =  
* Added selectable number of result variations

= 1.2.3 =  
* `%rand%` now returns a random digit (0–9)  
* Fixed bug with stray `\` characters  
* Code formatting and optimization

= 1.2.2 =  
* Added multi-language support (currently Russian and English)

= 1.2.1 =  
* Added GitHub Updater support  
* Fixed changelog.md  
* Updated package metadata  
* Fixed /languages/ directory  
* Fixed generator template

= 1.2.0 =  
* Added language file support  
* Added Russian and English translations  
* Updated example templates  
* Reduced max form character limit to 4000

= 1.1.1 =  
* Added IDs to all fields and elements  
* Set input width for better mobile UX  
* UI layout improvements  
* Added composer support (composer.json)  
* Expanded ISSUE_TEMPLATE.md  
* Code optimization

= 1.1.0 =  
* Fixed issue with multiple spaces  
* Added GitHub project link  
* Added results reset button  
* Improved result display styling  
* Improved handling of result count variations  
* Cleaned up excessive backslashes in output

= 1.0.2 =  
* Fixed line break issue  
* Added GitHub support files  
* Corrected result rendering

= 1.0.1 =  
* Combined all logic into one function, removed redundant code, fixed bugs  
* Successfully tested on demo site  
Next:  
* Improve UI  
* Enable generation with proper line breaks

= 1.0.0 =  
* Initial Release
