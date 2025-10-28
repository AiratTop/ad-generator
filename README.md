# [Ad Generator](https://github.com/AiratTop/ad-generator)
* Contributors: [AiratTop](https://github.com/AiratTop)
* Requires at least: 3.8  
* Tested up to: 5.6  
* Stable tag: [2.2.0](https://github.com/AiratTop/ad-generator/releases/latest)  
* License: GPLv3  
* License URI: https://www.gnu.org/licenses/gpl-3.0.html  

Professional text randomizer and ad generator by AiratTop.

## Description

Professional text randomizer and ad generator by AiratTop.

## Installation

1. Go to 'Plugins > Add New'
2. Click 'Upload Plugin'
3. Upload the 'ad-generator.zip' file
4. Activate Ad Generator on your Plugins page
5. Add the `[ad_generator]` shortcode to a WordPress page

## Setup

1. Create a new WordPress page, insert `[ad_generator]` shortcode, and save
2. Visit the page and use the ad generator
3. Enjoy!

## Screenshots  
### In Russian:  
![ad-generator rus](https://user-images.githubusercontent.com/4050715/44120760-d26f5f34-a036-11e8-839a-da43067ff6a1.png)

### In English:  
![ad-generator eng](https://user-images.githubusercontent.com/4050715/44120977-97561f54-a037-11e8-9600-054306c0b98b.png)

### Process GIF:
![ad-generator animation](https://user-images.githubusercontent.com/4050715/44121069-eda8e5a8-a037-11e8-854d-3d6ac1cb5780.gif)

---

# [Documentation](https://github.com/AiratTop/ad-generator/wiki)

## What is a text randomizer?

A tool for industrial-level generation of pseudo-unique content. Often used when submitting a website to multiple directories — each listing gets a unique description from a search engine's perspective. Unlike typical synonymizers or content generators (doorway tools), this one preserves readability.

## How it works

Start with a base text, e.g.:

> Some believe that both copywriting (writing texts) and rewriting (reworking existing ones) can successfully be entrusted to a text randomizer — a special program.

### Apply the randomization syntax:
1. If "text 1" can be replaced with "text 2" or "text 3", wrap with: `{text 1|text 2|text 3}`
2. If "text" is optional, use: `{|text}`
3. If the sequence "text 1 text 2 text 3" can be shuffled, use: `[text 1|text 2|text 3]`
4. For comma-separated shuffle: `[+,+text 1|text 2|text 3]`
5. For paragraph shuffle: `paragraph1|paragraph2|paragraph3`
6. To escape special characters (`{, }, |, [, ], +, \`), use: `\{, \}, \|, \[, \], \+, \\`
7. To insert a random digit (0–9): use `%rand%`

**Instructions support unlimited nesting.**

### Quick example:
```
{{Some|Many|There is a} belief|{Some|Many} think} that 
[+and+ 
 {copywriting (writing texts)|writing texts (copywriting)|writing texts|copywriting}
|{rewriting (reworking texts)|reworking texts (rewriting)|reworking texts|rewriting}
] [{|can successfully}|can] be entrusted to 
[+–+{a text randomizer|a randomizer of {|texts|content}}|a {special|dedicated} {program|tool}]
.
```

This code can generate 24,576 unique variations, such as:

> Many believe that copywriting and rewriting (reworking texts) can successfully be entrusted to a dedicated tool — a randomizer.

or

> Some think that reworking texts and writing can be entrusted to a text randomizer — a special program.

### To summarize:
* `{text 1|text 2|text 3}` – alternatives
* `[text 1|text 2|text 3]` – permutations
* `[+delimiter+text 1|text 2|text 3]` – permutations with delimiter
* Special character escaping: `\{, \}, \|, \[, \], \+, \\`
* `%rand%` returns a random number (0–9)
* Supports nested instructions

## Command-line version

You can run the script via CLI, without installing the WordPress plugin — faster and unrestricted.

Run the file `ad-generator-cli.php` as a regular PHP script, passing the input template file, number of outputs, and (optionally) output file:

### Example command:
```
php ad-generator-cli.php -n 300 -f template.txt -o result.txt
```

Where:

* `-n` or `-N` – number of output variants (default: 300)
* `-f` or `--file` – template file (required)
* `-o` or `--out` – output file (default: `result-N.txt`)
* `-h` or `--help` – show help

Run from the plugin directory. Make sure you have read/write permissions.

## [Template Examples](https://github.com/AiratTop/ad-generator/wiki/Template-Examples)

### Ad example for “Apartment Renovation” niche:

**Title:**
```
Turnkey renovation of {apartments|offices|cottages}. Warranty, {team|quality}
```

**Body:**
```
A team of {highly qualified|experienced|reliable} {repairmen|workers|craftsmen} will {perform|carry out} a {quality|professional} renovation of {your apartment|your home|your residence} at a {reasonable|affordable} {price|cost}. {We offer|We provide|Why us|Choose us|Contact us}:
— {Bulk purchase of materials at {wholesale|discounted} {prices|rates}|All types of work done in {short|minimal} time}.
— {{All|Our} {workers|repairmen} are citizens of the Russian Federation|{Experience|Tenure} of {all|our} {workers|staff|builders} – {5|6|7} years}.
— Warranty on {all types of work|{any|completed} work} for {1|2|3} years.
— {{All|Any} types of {repair|finishing|construction} work {of any complexity|“from A to Z”|turnkey}.|Free visit of a {specialist|measurer} for consultation and measurements.}
{===|* * *|***|# # #|~ ~ ~|- — -|___}
{->>|=>|>>|->} ONLY until %DATE — get a DISCOUNT on turnkey {apartment|room|property} renovation – {15|20|10}%!!!
{✆|☏|►} {CALL US|PHONE|CALL NOW|Book a FREE estimate}: %PHONE
```

---

### More examples:

#### Days of the week:
```
{Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday}
```
or
```
{Mon|Tue|Wed|Thu|Fri|Sat|Sun}
```

#### Months:
```
{January|February|March|April|May|June|July|August|September|October|November|December}
```

#### Days of the month:
```
{{|1|2}{0|1|2|3|4|5|6|7|8|9}|30|31}
```
or
```
{1|2|...|31}
```

#### Numbers (0–9):
```
{1|2|3|4|5|6|7|8|9|0}
```
or
```
%rand%
```

#### Two-digit numbers (10–99):
```
{1|2|3|4|5|6|7|8|9}%rand%
```

#### English alphabet:
```
{A|B|C|D|...|Z}
```

#### Russian alphabet:
```
{А|Б|В|...|Я}
```

Sky’s the limit — you're only bound by your imagination!

---

## [Changelog](https://github.com/AiratTop/ad-generator/blob/master/CHANGELOG.md)
