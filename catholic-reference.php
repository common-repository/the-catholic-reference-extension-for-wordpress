<?php
/*
Plugin Name: Catholic Reference Extension
Plugin URI: http://blog.purepistos.net/index.php/cre/
Description: The Catholic Reference Extension makes scripture and Catechism references pop up the actual bible or Catechism text.
Version: 0.8.13
Author: Pistos
Author URI: http://blog.purepistos.net

Usage:

The CRE will take most common Scripture references in posts and convert them
automatically to the HTML code necessary to show popups, etc.  You can use
Full book names (e.g. Genesis 1:1) or abbreviated book names, with or without
a period (e.g. Exo. 2:10-15, Jn 3:16).

To prevent the CRE from transforming text which appears to be a scripture reference,
put an exclamation mark before the reference (e.g. !Matthew 28:20).  You can also
use the string "[nocathref]" anywhere in the post to prevent the CRE from operating
on any references in the whole post.

To reference the Catechism of the Catholic Church, use paragraph numbers.
Multiple paragraphs can be enumerated using commas and dashes.  Examples:

CCC 1234,1237-1239
CCC pp1234,1237-1239
CCC paragraph 1234
CCC paragraphs 1234,1237

--------------------------------------

Copyright (c) 2007 Pistos
Released under the GPL license, version 2
http://www.gnu.org/licenses/gpl.txt

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function cathref_initialize() {
    global
        $cathref_version,
        $cathref_book_numbers,
        $cathref_book_names,
        $cathref_njb_books,
        $cathref_hebrew_books,
        $cathref_wp_option_name,
        $cathref_site,
        $cathref_popups
    ;
    
    $cathref_version = "0.8.10";
    
    $cathref_book_numbers = array(
        'ge' => 1,
        'gen' => 1,
        'genesis' => 1,
        'ex' => 2,
        'exo' => 2,
        'exod' => 2,
        'exodus' => 2,
        'lv' => 3,
        'lev' => 3,
        'levit' => 3,
        'leviticus' => 3,
        'num' => 4,
        'numbers' => 4,
        'de' => 5,
        'deu' => 5,
        'deut' => 5,
        'deuter' => 5,
        'deutero' => 5,
        'deuteronomy' => 5,
        'jo' => 6,
        'jos' => 6,
        'josh' => 6,
        'joshua' => 6,
        'jg' => 7,
        'judges' => 7,
        'ru' => 8,
        'ruth' => 8,
        '1 sa' => 9,
        'i sa' => 9,
        '1 sm' => 9,
        'i sm' => 9,
        '1 sam' => 9,
        'i sam' => 9,
        '1 samuel' => 9,
        'i samuel' => 9,
        '2 sa' => 10,
        '2 sm' => 10,
        '2 sam' => 10,
        '2 samuel' => 10,
        'ii sa' => 10,
        'ii sm' => 10,
        'ii sam' => 10,
        'ii samuel' => 10,
        '1 kn' => 11,
        '1 kg' => 11,
        '1 ki' => 11,
        '1 kings' => 11,
        'i kn' => 11,
        'i kg' => 11,
        'i ki' => 11,
        'i kings' => 11,
        '3 kn' => 11,
        '3 kg' => 11,
        '3 ki' => 11,
        '3 kings' => 11,
        'iii kn' => 11,
        'iii kg' => 11,
        'iii ki' => 11,
        'iii kings' => 11,
        '2 kn' => 12,
        '2 kg' => 12,
        '2 ki' => 12,
        '2 kings' => 12,
        'ii kn' => 12,
        'ii kg' => 12,
        'ii ki' => 12,
        'ii kings' => 12,
        '4 kn' => 12,
        '4 kg' => 12,
        '4 ki' => 12,
        '4 kings' => 12,
        'iv kn' => 12,
        'iv kg' => 12,
        'iv ki' => 12,
        'iv kings' => 12,
        '1 ch' => 13,
        '1 chr' => 13,
        '1 chron' => 13,
        '1 chronicles' => 13,
        '1 paralipomenon' => 13,
        'i ch' => 13,
        'i chr' => 13,
        'i chron' => 13,
        'i chronicles' => 13,
        'i paralipomenon' => 13,
        '2 ch' => 14,
        '2 chr' => 14,
        '2 chron' => 14,
        '2 chronicles' => 14,
        '2 paralipomenon' => 14,
        'ii ch' => 14,
        'ii chr' => 14,
        'ii chron' => 14,
        'ii chronicles' => 14,
        'ii paralipomenon' => 14,
        'ez' => 15,
        'ezra' => 15,
        '1 es' => 15,
        '1 esdras' => 15,
        'i es' => 15,
        'i esdras' => 15,
        'ne' => 16,
        'neh' => 16,
        'nehemiah' => 16,
        '2 es' => 16,
        '2 esdras' => 16,
        'ii es' => 16,
        'ii esdras' => 16,
        'tb' => 17,
        'tob' => 17,
        'tobit' => 17,
        'tobias' => 17,
        'judith' => 18,
        'es' => 19,
        'est' => 19,
        'esther' => 19,
        'jb' => 20,
        'job' => 20,
        'ps' => 21,
        'pss' => 21,
        'psa' => 21,
        'psalm' => 21,
        'psalms' => 21,
        'pr' => 22,
        'pb' => 22,
        'pro' => 22,
        'prov' => 22,
        'proverb' => 22,
        'proverbs' => 22,
        'ec' => 23,
        'ecc' => 23,
        'eccl' => 23,
        'eccles' => 23,
        'ecclesiastes' => 23,
        'sg' => 24,
        'song' => 24,
        'song of songs' => 24,
        'song of songs' => 24,
        'canticle' => 24,
        'canticles' => 24,
        'canticle of canticles' => 24,
        'ws' => 25,
        'wis' => 25,
        'wisdom' => 25,
        'sr' => 26,
        'sir' => 26,
        'sirach' => 26,
        'ecclesiasticus' => 26,
        'is' => 27,
        'isa' => 27,
        'isaiah' => 27,
        'isaias' => 27,
        'je' => 28,
        'jer' => 28,
        'jerem' => 28,
        'jeremiah' => 28,
        'jeremias' => 28,
        'la' => 29,
        'lm' => 29,
        'lament' => 29,
        'lamentation' => 29,
        'lamentations' => 29,
        'ba' => 30,
        'bar' => 30,
        'baruch' => 30,
        'ez' => 31,
        'ezekiel' => 31,
        'ezechiel' => 31,
        'da' => 32,
        'dn' => 32,
        'dan' => 32,
        'daniel' => 32,
        'ho' => 33,
        'hs' => 33,
        'hosea' => 33,
        'os' => 33,
        'osee' => 33,
        'jo' => 34,
        'joel' => 34,
        'am' => 35,
        'amo' => 35,
        'amos' => 35,
        'ob' => 36,
        'oba' => 36,
        'obad' => 36,
        'obadiah' => 36,
        'abdias' => 36,
        'jonah' => 37,
        'jonas' => 37,
        'mi' => 38,
        'mic' => 38,
        'micah' => 38,
        'michaes' => 38,
        'na' => 39,
        'nah' => 39,
        'nahum' => 39,
        'ha' => 40,
        'hab' => 40,
        'hb' => 40,
        'hk' => 40,
        'haba' => 40,
        'habak' => 40,
        'habac' => 40,
        'habacuc' => 40,
        'habakkuk' => 40,
        'zp' => 41,
        'zep' => 41,
        'zeph' => 41,
        'zephaniah' => 41,
        'sophonias' => 41,
        'ha' => 42,
        'hag' => 42,
        'haggai' => 42,
        'aggeus' => 42,
        'ze' => 43,
        'zech' => 43,
        'zechariah' => 43,
        'zacharias' => 43,
        'mal' => 44,
        'ml' => 44,
        'malachi' => 44,
        'malachias' => 44,
        '1 ma' => 45,
        '1 mc' => 45,
        '1 mac' => 45,
        '1 macc' => 45,
        '1 machabees' => 45,
        '1 maccabees' => 45,
        'i ma' => 45,
        'i mc' => 45,
        'i mac' => 45,
        'i macc' => 45,
        'i machabees' => 45,
        'i maccabees' => 45,
        '2 ma' => 46,
        '2 mc' => 46,
        '2 mac' => 46,
        '2 macc' => 46,
        '2 machabees' => 46,
        '2 maccabees' => 46,
        'ii ma' => 46,
        'ii mc' => 46,
        'ii mac' => 46,
        'ii macc' => 46,
        'ii machabees' => 46,
        'ii maccabees' => 46,
        'mt' => 47,
        'mat' => 47,
        'matt' => 47,
        'matthew' => 47,
        'mk' => 48,
        'mark' => 48,
        'lk' => 49,
        'luke' => 49,
        'jn' => 50,
        'john' => 50,
        'acts' => 51,
        'ac' => 51,
        'ro' => 52,
        'rm' => 52,
        'rom' => 52,
        'romans' => 52,
        '1 co' => 53,
        '1 cor' => 53,
        '1 corinthians' => 53,
        'i co' => 53,
        'i cor' => 53,
        'i corinthians' => 53,
        '2 co' => 54,
        '2 cor' => 54,
        '2 corinthians' => 54,
        'ii co' => 54,
        'ii cor' => 54,
        'ii corinthians' => 54,
        'ga' => 55,
        'gal' => 55,
        'galatians' => 55,
        'ep' => 56,
        'eph' => 56,
        'ephesians' => 56,
        'ph' => 57,
        'phi' => 57,
        'phil' => 57,
        'philippians' => 57,
        'co' => 58,
        'cl' => 58,
        'col' => 58,
        'coloss' => 58,
        'colossians' => 58,
        '1 th' => 59,
        '1 thes' => 59,
        '1 thess' => 59,
        '1 thessalonians' => 59,
        'i th' => 59,
        'i thes' => 59,
        'i thess' => 59,
        'i thessalonians' => 59,
        '2 th' => 60,
        '2 thes' => 60,
        '2 thess' => 60,
        '2 thessalonians' => 60,
        'ii th' => 60,
        'ii thes' => 60,
        'ii thess' => 60,
        'ii thessalonians' => 60,
        '1 ti' => 61,
        '1 tm' => 61,
        '1 tim' => 61,
        '1 timothy' => 61,
        'i ti' => 61,
        'i tm' => 61,
        'i tim' => 61,
        'i timothy' => 61,
        '2 ti' => 62,
        '2 tm' => 62,
        '2 tim' => 62,
        '2 timothy' => 62,
        'ii ti' => 62,
        'ii tm' => 62,
        'ii tim' => 62,
        'ii timothy' => 62,
        'ti' => 63,
        'tit' => 63,
        'titus' => 63,
        'pm' => 64,
        'philemon' => 64,
        'he' => 65,
        'hb' => 65,
        'heb' => 65,
        'hebrews' => 65,
        'ja' => 66,
        'jam' => 66,
        'js' => 66,
        'james' => 66,
        '1 pe' => 67,
        '1 pt' => 67,
        '1 pet' => 67,
        '1 peter' => 67,
        'i pe' => 67,
        'i pt' => 67,
        'i pet' => 67,
        'i peter' => 67,
        '2 pe' => 68,
        '2 pt' => 68,
        '2 pet' => 68,
        '2 peter' => 68,
        'ii pe' => 68,
        'ii pt' => 68,
        'ii pet' => 68,
        'ii peter' => 68,
        '1 jo' => 69,
        '1 jn' => 69,
        '1 john' => 69,
        'i jo' => 69,
        'i jn' => 69,
        'i john' => 69,
        '2 jo' => 70,
        '2 jn' => 70,
        '2 john' => 70,
        'ii jo' => 70,
        'ii jn' => 70,
        'ii john' => 70,
        '3 jo' => 71,
        '3 jn' => 71,
        '3 john' => 71,
        'iii jo' => 71,
        'iii jn' => 71,
        'iii john' => 71,
        'iii john' => 71,
        'jd' => 72,
        'jude' => 72,
        'rv' => 73,
        'rev' => 73,
        'revelation' => 73,
        'revelations' => 73,
        'apocalypse' => 73,
        'apo' => 73,
        'apoc' => 73,
    );
        
    $cathref_book_names = array(
        1 => 'Genesis',
        2 => 'Exodus',
        3 => 'Leviticus',
        4 => 'Numbers',
        5 => 'Deuteronomy',
        6 => 'Joshua',
        7 => 'Judges',
        8 => 'Ruth',
        9 => '1 Samuel',
        10 => '2 Samuel',
        11 => '1 Kings',
        12 => '2 Kings',
        13 => '1 Chronicles',
        14 => '2 Chronicles',
        15 => 'Ezra',
        16 => 'Nehemiah',
        17 => 'Tobit',
        18 => 'Judith',
        19 => 'Esther',
        20 => 'Job',
        21 => 'Psalm',
        22 => 'Proverbs',
        23 => 'Ecclesiastes',
        24 => 'Song of Songs',
        25 => 'Wisdom',
        26 => 'Sirach',
        27 => 'Isaiah',
        28 => 'Jeremiah',
        29 => 'Lamentations',
        30 => 'Baruch',
        31 => 'Ezekiel',
        32 => 'Daniel',
        33 => 'Hosea',
        34 => 'Joel',
        35 => 'Amos',
        36 => 'Obadiah',
        37 => 'Jonah',
        38 => 'Micah',
        39 => 'Nahum',
        40 => 'Habakkuk',
        41 => 'Zephaniah',
        42 => 'Haggai',
        43 => 'Zechariah',
        44 => 'Malachi',
        45 => '1 Maccabees',
        46 => '2 Maccabees',
        47 => 'Matthew',
        48 => 'Mark',
        49 => 'Luke',
        50 => 'John',
        51 => 'Acts',
        52 => 'Romans',
        53 => '1 Corinthians',
        54 => '2 Corinthians',
        55 => 'Galatians',
        56 => 'Ephesians',
        57 => 'Philippians',
        58 => 'Colossians',
        59 => '1 Thessalonians',
        60 => '2 Thessalonians',
        61 => '1 Timothy',
        62 => '2 Timothy',
        63 => 'Titus',
        64 => 'Philemon',
        65 => 'Hebrews',
        66 => 'James',
        67 => '1 Peter',
        68 => '2 Peter',
        69 => '1 John',
        70 => '2 John',
        71 => '3 John',
        72 => 'Jude',
        73 => 'Revelation',
    );
        
    $cathref_hebrew_books = array(
        1 => '01',
        2 => '02',
        3 => '03',
        4 => '04',
        5 => '05',
        6 => '06',
        7 => '07',
        9 => '08a',
        10 => '08b',
        11 => '09a',
        12 => '09b',
        27 => '10',
        28 => '11',
        31 => '12',
        33 => '13',
        34 => '14',
        35 => '15',
        36 => '16',
        37 => '17',
        38 => '18',
        39 => '19',
        40 => '20',
        41 => '21',
        42 => '22',
        43 => '23',
        44 => '24',
        13 => '25a',
        14 => '25b',
        21 => '26',
        20 => '27',
        22 => '28',
        8 => '29',
        24 => '30',
        23 => '31',
        29 => '32',
        19 => '33',
        32 => '34',
        15 => '35a',
        16 => '35b',
    );
    
    $cathref_njb_books = array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16',
        17 => NULL,
        18 => NULL,
        19 => '17',
        20 => '18',
        21 => '19',
        22 => '20',
        23 => '21',
        24 => '22',
        25 => NULL,
        26 => NULL,
        27 => '23',
        28 => '24',
        29 => '25',
        30 => NULL,
        31 => '26',
        32 => '27',
        33 => '28',
        34 => '29',
        35 => '30',
        36 => '31',
        37 => '32',
        38 => '33',
        39 => '34',
        40 => '35',
        41 => '36',
        42 => '37',
        43 => '38',
        44 => '39',
        45 => NULL,
        46 => NULL,
        47 => '40',
        48 => '41',
        49 => '42',
        50 => '43',
        51 => '44',
        52 => '45',
        53 => '46',
        54 => '47',
        55 => '48',
        56 => '49',
        57 => '50',
        58 => '51',
        59 => NULL,
        60 => NULL,
        61 => '52',
        62 => '53',
        63 => '54',
        64 => '55',
        65 => '56',
        66 => '57',
        67 => '58',
        68 => '59',
        69 => '60',
        70 => '61',
        71 => '62',
        72 => '63',
        73 => '64',
    );
        
    $cathref_wp_option_name = "catholic-reference-extension-options";
    $cathref_site = "http://blog.purepistos.net/index.php/cre";
    
    $cathref_popups = array();

    add_action( 'wp_head', 'cathref_header' );
    add_action( 'wp_footer', 'cathref_footer' );
    add_action( 'admin_head', 'cathref_admin_header' );
    add_action( 'dbx_post_sidebar', 'cathref_admin_sidebar' );
    add_filter( 'the_content', 'cathref_filter' );
    add_action( 'admin_menu', 'cathref_options_page_adder' );
    add_action( 'activate_catholic-reference/catholic-reference.php', 'cathref_on_activation' );
}
    
function cathref_get_config() {
    global $cathref_wp_option_name;
    
    // Defaults
    $config = array(
        'show_popup_on_hover' => true,
        'draw_shadows' => true,
        'drb_dir' => dirname( __FILE__ ) . '/texts/drb',
        'ccc_dir' => dirname( __FILE__ ) . '/texts/ccc',
        'popup_width' => 300,
        'quote_prefix' => "<blockquote>",
        'show_quote_header' => true,
        'quote_suffix' => "</blockquote>",
        'show_link_NAB' => true,
        'show_link_KJV' => true,
        'show_link_NIV' => true,
        'show_link_Vulg' => true,
        'show_link_Greek' => true,
        'show_link_Hebrew' => true,
        'show_link_LXX' => true,
        'show_link_NJB' => true,
        'link_behaviour' => 'target',
    );
    
    
    // Stored options
    $stored_config = get_option( $cathref_wp_option_name );
    if( ! empty( $stored_config ) ) {
        foreach( $stored_config as $key => $value ) {
            $config[ $key ] = $value;
        }
    }
    
    // Save options
    update_option( $cathref_wp_option_name, $config );
    
    return $config;
}
    
function cathref_on_activation() {
    cathref_get_config();
}
    
function cathref_drb_text_exists() {
    $config = cathref_get_config();
    return( file_exists( $config[ 'drb_dir' ] . "/1.book" ) );
}
    
function cathref_ccc_text_exists() {
    $config = cathref_get_config();
    return( file_exists( $config[ 'ccc_dir' ] . "/ccc-1-100.txt" ) );
}
        
/* ****************************************** */
    
function cathref_header() {
    $config = cathref_get_config();
    $cathref_plugin_dir = get_settings( 'siteurl' ) . "/wp-content/plugins/catholic-reference";
    ?>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php print $cathref_plugin_dir ?>/catholic-reference.css" />
    <script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/js/jquery-1.1.3.1.pack.js"></script>
    <script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/catholic-reference.js"></script>
    <?php
    $config = cathref_get_config();
    if( $config[ 'show_popup_on_hover' ] ) {
        ?><script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/js/option-hover.js"></script><?php
    } else {
        ?><script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/js/option-click.js"></script><?php
    }
    ?>
    <style type="text/css">
        .scripture_popup, .scripture_popup_shadow, .ccc_popup, .ccc_popup_shadow {
            width: <?php echo( $config[ 'popup_width' ] ); ?>px;
        }
        <?php
        if( ! $config[ 'show_popup_on_hover' ] ) {
            ?>
            .scripture_reference:hover, .ccc_reference:hover {
                cursor: pointer;
            }
            <?php
        }
        ?>
    </style>
    <?php
}
    
function cathref_admin_header() {
    $cathref_plugin_dir = get_settings( 'siteurl' ) . "/wp-content/plugins/catholic-reference";
    ?>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php print $cathref_plugin_dir ?>/catholic-reference.css" />
    <script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/js/jquery-1.1.3.1.pack.js"></script>
    <script type="text/javascript" src="<?php print $cathref_plugin_dir ?>/catholic-reference.js"></script>
    <?php
}

function cathref_admin_sidebar() {
    ?>
    <fieldset id='cathref_fieldset' class='dbx-box'>
      <h3 class='dbx-handle'>CRE</h3>
      <div class='dbx-content'>
        <label>
          <input type="checkbox" id="disable-cre"/>
          Disable the Catholic Reference Extension in this post/page
        </label>
      </div>
    </fieldset>
    <?
}

function cathref_footer() {
    global $cathref_site, $cathref_version;
    ?>
    <div class="cathref_footer">
    Scripture and Catechism references powered by
    <a href="<?php echo $cathref_site; ?>" title="the Catholic Reference Extension for Wordpress, version <?php echo $cathref_version; ?>">the CRE</a>.
    </div>
    <?
}
    
function cathref_scripture_passage( $book_number, $chapters_and_verses ) {
    global $cathref_verses_added;
    
    $config = cathref_get_config();
    $cathref_verses_added = 0;
    $scripture_text = "";
    $lines = file( $config[ 'drb_dir' ] . "/$book_number.book", FILE_IGNORE_NEW_LINES );
    $chapters = array_keys( $chapters_and_verses );
    $previous_chapter = '';
    foreach( $lines as $line ) {
        $parts = explode( "\t", $line, 3 );
        $line_chapter = $parts[ 0 ];
        $line_verse = (int) $parts[ 1 ];
        $line_text = $parts[ 2 ];
        if( in_array( $line_chapter, $chapters ) ) {
            if( in_array( $line_verse, $chapters_and_verses[ $line_chapter ] ) ) {
                if( count( $chapters ) > 1 && $line_chapter != $previous_chapter ) {
                    $chapter_number = "<span class='chapter_number'>$line_chapter</span>";
                    $previous_chapter = $line_chapter;
                } else {
                    $chapter_number = '';
                }
                $scripture_text .= "<div class='verse'>";
                $scripture_text .= "$chapter_number<span class='verse_number'>$line_verse</span>$line_text";
                $scripture_text .= "</div>";
                $cathref_verses_added++;
            }
        }
    }
    return $scripture_text;
}

function cathref_substitute_scripture( $matches ) {
    global $cathref_book_numbers, $cathref_book_names, $cathref_hebrew_books, $cathref_njb_books, $cathref_verses_added, $cathref_popups;
    
    $config = cathref_get_config();
    
    $original_span = array_shift( $matches );
    $lead_char = array_shift( $matches );
    if( $lead_char == "!" ) {
        $retval = substr( $original_span, 1 );
    } else {
        $original_book = array_shift( $matches );
        $book = strtolower( $original_book );
        $book_number = $cathref_book_numbers[ $book ] + 0;
        
        if( ! $book_number ) {
            $retval = $original_span;
        } else {
            $retval = "";
            $chapter_and_verses = array();
            $range_strs = array();
            $start_chapter = 0;
            $start_verse = 0;
            
            // Parse out chapter and verse ranges.
            
            while( $chapter_and_verse_ranges = array_shift( $matches ) ) {
                if( preg_match(
                    "/(\\d+) *: *" .  // chapter
                    "(\\d+(?: *- *\\d+)?)" . "(?: *, *(\\d+(?: *- *\\d+)?))*/i",  // verses
                    $chapter_and_verse_ranges,
                    $matches2
                ) ) {
                    $full_range_match = array_shift( $matches2 );
                    $chapter = array_shift( $matches2 );
                    
                    $ranges = array();
                    foreach ( $matches2 as $range ) {
                        if( preg_match( "/(\\d+)[^0-9]+(\\d+)/", $range, $range_matches ) ) {
                            $ranges[] = array( 'start' => $range_matches[ 1 ], 'end' => $range_matches[ 2 ] );
                        } else {
                            preg_match( "/(\\d+)/", $range, $range_matches );
                            $ranges[] = array( 'start' => $range_matches[ 1 ], 'end' => $range_matches[ 1 ] );
                        }
                    }
                    if( ! $start_chapter ) {
                        $start_chapter = $chapter;
                    }
                    if( ! $start_verse ) {
                        $start_verse = $ranges[ 0 ][ 'start' ];
                    }
                    
                    $verses = array();
                    $range_strs[ $chapter ] = array();
                    foreach( $ranges as $range ) {
                        for( $i = $range[ 'start' ]; $i <= $range[ 'end' ]; $i++ ) {
                            if( $i >= 0 && $i <= 176 ) {
                                $verses[] = $i;
                            }
                        }
                        if( $range[ 'start' ] == $range[ 'end' ] ) {
                            $range_strs[ $chapter ][] = $range[ 'start' ];
                        } else {
                            $range_strs[ $chapter ][] = $range[ 'start' ] . "-" . $range[ 'end' ];
                        }
                    }
                    
                    $chapter_and_verses[ $chapter ] = $verses;
                
                }
            }
            
            // Build actual Scripture text from the parsed ranges.
            
            $sub_passages = array();
            foreach( $chapter_and_verses as $chapter => $verses ) {
                $sub_passages []= "$chapter:" . join( ',', $range_strs[ $chapter ] );
            }
            $passage = $cathref_book_names[ $book_number ] . " " .
                join( '; ', $sub_passages );
            
            if( $lead_char == '`' ) {
                $retval .= $config[ 'quote_prefix' ];
                if( $config[ 'show_quote_header' ] ) {
                    $retval .= "<div class='cathref_quote_header'>$passage</div>";
                }
                $retval .= cathref_scripture_passage( $book_number, $chapter_and_verses );
                $retval .= $config[ 'quote_suffix' ];
            } else {
        
                $id = ( microtime() + rand( 0, 1000 ) );
                
                $retval .= "$lead_char<span class=\"scripture_reference\" refid=\"$id\">$passage</span>";
                
                $popup = "";
                    
                // Header
                $popup .= "<div class='scripture_header'>";
                $popup .= "<div class='cathref_close_button' closeid='$id'><div class='cathref_close_button_highlight'></div></div>";
                $popup .= "<span class='passage'>" . $passage . "</span><br />";
                $popup .= "<span class='alternates'>View in: ";
                
                $book_no_spaces = str_replace( ' ', '', $cathref_book_names[ $book_number ] );
                if( $book_no_spaces == 'Psalm' ) {
                    $psalm_fix = 's';
                }
                $opener = cathref_opener();
                if( $config[ 'link_behaviour' ] != 'nil' ) {
                    $title = "title='(opens $passage in a new window)'";
                }
                
                // NAB
                if( $config[ 'show_link_NAB' ] ) {
                    $nab_book = strtolower( $book_no_spaces );
                    $popup .= "<a href='http://www.usccb.org/nab/bible/$nab_book$psalm_fix/$nab_book$chapter.htm#v$start_verse' $opener $title>NAB</a>";
                }
                
                // NIV
                if( $config[ 'show_link_NIV' ] ) {
                    $popup .= " <a href='http://www.biblegateway.com/passage/?search=" . urlencode( $passage ) . "&amp;version=31' $opener $title>NIV</a>";
                }
                // KJV
                if( $config[ 'show_link_KJV' ] ) {
                    $popup .= " <a href='http://www.biblegateway.com/passage/?search=" . urlencode( $passage ) . "&amp;version=9' $opener $title>KJV</a>";
                }
                // NJB
                if( $config[ 'show_link_NJB' ] ) {
                    $jbook = $cathref_njb_books[ $book_number ];
                    if( $jbook ) {
                        $popup .= " <a href='http://www.catholic.org/bible/book.php?id=$jbook&amp;bible_chapter=$chapter' $opener $title>NJB</a>";
                    }
                }
                
                // Latin Vulgate
                if( $config[ 'show_link_Vulg' ] ) {
                    if( $book_number < 47 ) {
                        $vulg_testament = 0;
                        $vulg_book = $book_number;
                    } else {
                        $vulg_testament = 1;
                        $vulg_book = $book_number - 46;
                    }
                    $popup .= " <a href='http://www.latinvulgate.com/verse.aspx?t=$vulg_testament&amp;b=$vulg_book&amp;c=$chapter#$chapter" . "_" . $start_verse . "' $opener $title>Vulg</a>";
                }
                
                if( $book_number < 47 ) {
                    // Septuagint (LXX)
                    if( $config[ 'show_link_LXX' ] ) {
                        $popup .= " <a href='http://septuagint.org/LXX/$book_no_spaces$psalm_fix/$book_no_spaces$psalm_fix$chapter.html' $opener $title>LXX</a>";
                    }
                    // Hebrew - Masoretic Text
                    if( $config[ 'show_link_Hebrew' ] ) {
                        $hbook = $cathref_hebrew_books[ $book_number ];
                        if( $hbook ) {
                            $hchapter = sprintf( "%02d", ( 0 + $chapter ) );
                            $popup .= " <a href='http://www.mechon-mamre.org/p/pt/pt$hbook$hchapter.htm#$start_verse' $opener $title>Hebrew</a>";
                        }
                    }
                } else {
                    // Nestle-Aland Greek NT
                    if( $config[ 'show_link_Greek' ] ) {
                        $nt_book = $book_number - 46;
                        $popup .= " <a href='http://www.greekbible.com/index.php?b=$nt_book&amp;c=$chapter' $opener $title>Greek</a>";
                    }
                }
                
                $popup .= "</span>";
                $popup .= "</div>";
                
                // Body
                $popup .= "<div class='scripture_text'>";
                $popup .= cathref_scripture_passage( $book_number, $chapter_and_verses );
                $popup .= "</div>";
                
                $popup .= "</div>";
                
                if( $cathref_verses_added > 0 ) {
                    $popup1 = "<div class=\"scripture_popup\" popid=\"$id\">";
                    $popup1 .= $popup;
                    $cathref_popups[] = $popup1;
                    
                    $popup2 = "<div class=\"scripture_popup_shadow\" popid=\"$id\"></div>";
                    $cathref_popups[] = $popup2;
                } else {
                    $retval = $original_span;
                }
            }
        }
    }
    
    return $retval;
}
    
function cathref_ccc_paragraphs( $paras ) {
    global $cathref_paragraphs_added;
    
    $config = cathref_get_config();
    $cathref_paragraphs_added = 0;
    $text = "";
    
    foreach( $paras as $para ) {
        if( $para < 101 ) {
            $filename = "ccc-1-100.txt";
        } else if( $para > 2799 ) {
            $filename = "ccc-2800-2865.txt";
        } else {
            $x = ( (int)( $para / 100 ) ) * 100;
            $y = $x + 99;
            $filename = "ccc-$x-$y.txt";
        }
        $lines = file( $config[ 'ccc_dir' ] . "/$filename" , FILE_IGNORE_NEW_LINES );
        foreach ( $lines as $line ) {
            $parts = explode( "\t", $line );
            $file_para = array_shift( $parts );
            if( $para == $file_para ) {
                $text .= "<div class='cccp'>";
                $text .= "<span class='paragraph_number'>&para;$para</span> ";
                $text .= array_shift( $parts );
                if( count( $parts ) > 0 ) {
                    $text .= "<p>";
                    $text .= join( '</p><p>', $parts );
                    $text .= "</p>";
                }
                $text .= "</div>";
                $cathref_paragraphs_added++;
            }
        }
    }
    
    return $text;
}
    
function cathref_substitute_ccc( $matches ) {
    global $cathref_paragraphs_added, $cathref_popups;
    
    $config = cathref_get_config();
    $original_span = array_shift( $matches );
    $retval = $original_span;
    $lead_char = array_shift( $matches );
    
    if( $lead_char == '!' ) {
        $retval = substr( $retval, 1 );
    } else {
        $ranges = array();
        foreach ( $matches as $range ) {
            if( preg_match( "/(\\d+)[^0-9]+(\\d+)/", $range, $range_matches ) ) {
                $ranges[] = array( 'start' => $range_matches[ 1 ], 'end' => $range_matches[ 2 ] );
            } else {
                preg_match( "/(\\d+)/", $range, $range_matches );
                $ranges[] = array( 'start' => $range_matches[ 1 ], 'end' => $range_matches[ 1 ] );
            }
        }
        
        $paras = array();
        $range_strs = array();
        foreach( $ranges as $range ) {
            for( $i = $range[ 'start' ]; $i <= $range[ 'end' ]; $i++ ) {
                if( $i >= 0 && $i <= 2865 ) {
                    $paras[] = $i;
                }
            }
            if( $range[ 'start' ] == $range[ 'end' ] ) {
                $range_strs[] = $range[ 'start' ];
            } else {
                $range_strs[] = $range[ 'start' ] . "-" . $range[ 'end' ];
            }
        }
        $ccc_references = "CCC " . join( ',', $range_strs );
        
        if( $lead_char == '`' ) {
            $retval = $config[ 'quote_prefix' ];
            if( $config[ 'show_quote_header' ] ) {
                $retval .= "<div class='cathref_quote_header'>$ccc_references</div>";
            }
            $retval .= cathref_ccc_paragraphs( $paras );
            $retval .= $config[ 'quote_suffix' ];
        } else {
            $id = ( microtime() + rand( 0, 1000 ) );
            
            $popup1 = "<div class=\"ccc_popup\" popid=\"$id\">";
            $popup2 = "<div class=\"ccc_popup_shadow\" popid=\"$id\"></div>";
            $popup = "";
                
            // Header
            $popup .= "<div class='ccc_header'>";
            $popup .= "<div class='cathref_close_button' closeid='$id'><div class='cathref_close_button_highlight'></div></div>";
            $popup .= $ccc_references;
            $popup .= "</div>";
            
            // Body
            
            $popup .= "<div class='ccc_text'>";
            $popup .= cathref_ccc_paragraphs( $paras );
            $popup .= "</div>";
            
            $popup .= "</div>";
            
            $popup1 .= $popup;
            // $popup2 .= $popup;
            
            if( $cathref_paragraphs_added > 0 ) {
                $cathref_popups[] = $popup1;
                $cathref_popups[] = $popup2;
                $retval = "$lead_char<span class=\"ccc_reference\" refid=\"$id\">" . substr( $original_span, 1 ) . "</span>";
            }
        }
    }
    
    return $retval;
}

function cathref_filter( $content ) {
    global $cathref_book_numbers, $cathref_popups;
    
    $nocathref_removed = preg_replace( '/\[nocathref\]/i', '', $content );
    if( $nocathref_removed != $content ) {
        return $nocathref_removed;
    }
    
    $book_regexp = join( '|', array_keys( $cathref_book_numbers ) );

    if( cathref_drb_text_exists() ) {
        $content = preg_replace_callback(
            "/(.)($book_regexp)\\.? +" . // book
            "(" . // first chapter range
                "\\d+ *: *" .  // chapter
                "\\d+(?: *- *\\d+)?" .  // first verse range
                "(?: *, *\\d+(?: *- *\\d+)?)*" . // more verse ranges
            ")" .
            "(?: *; *" .
                "(" . // more chapter ranges
                    "\\d+ *: *" .  // chapter
                    "\\d+(?: *- *\\d+)?" .  // first verse range
                    "(?: *, *\\d+(?: *- *\\d+)?)*" . // more verse ranges
                ")" .
            ")*/i",
            'cathref_substitute_scripture',
            $content
        );
    }
    if( cathref_ccc_text_exists() ) {
        $content = preg_replace_callback(
            "/(.)CCC (?:p(?:p|aragraphs?)?)? *(\\d+(?: *- *\\d+)?)" . "(?: *, *(\\d+(?: *- *\\d+)?))*/",
            'cathref_substitute_ccc',
            $content
        );
    }
    
    foreach ( $cathref_popups as $popup ) {
        $content .= $popup;
    }
    
    //return $content . "<div class='cathref_test'></div>";
    return $content;
}

function cathref_opener( $target = 'bible' ) {
    $config = cathref_get_config();
    $opener = NULL;
    switch( $config[ 'link_behaviour' ] ) {
        case 'target':
            $opener = "target='$target'";
            break;
        case 'js':
            $opener = 'onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;"';
            break;
        case 'nil':
            $opener = '';
            break;
    }
    return $opener;
}
    
/* ******************************************
 * Options and configuration
 */
        
// Ensure that we have the texts to use (Scripture, Catechism, etc.)
// Returns NULL if all texts are found.
// Returns a notice message in a string for any missing texts.
function cathref_check_texts( $config ) {
    global $cathref_notices, $cathref_site;
    
    $message = "";
    
    if( ! cathref_drb_text_exists() ) {
        $message .= "Scripture text files not found.  Scripture references will not be active.<br />";
    }
    if( ! cathref_ccc_text_exists() ) {
        $message .= "Catechism text files not found.  References to the Catechism will not be active.<br />";
    }
    
    if( ! empty( $message ) ) {
        $message .= " The texts used by the CRE can be obtained <a href='$cathref_site' target='cre'>here</a>.<br />";
        $cathref_notices .= $message;
    }
}
    
function cathref_options_page() {
    global $cathref_notices, $cathref_version, $cathref_wp_option_name;
    
    $config = cathref_get_config();
    $cathref_notices = "";
    if( isset( $_POST[ 'cathref_submit' ] ) ) {
        if( isset( $_POST[ 'show_popup_on_hover' ] ) ) {
            $config[ 'show_popup_on_hover' ] = (bool) $_POST[ 'show_popup_on_hover' ];
        }
        $config[ 'show_quote_header' ] = (bool) $_POST[ 'show_quote_header' ];
        if( isset( $_POST[ 'drb_dir' ] ) ) {
            $config[ 'drb_dir' ] = $_POST[ 'drb_dir' ];
        }
        if( isset( $_POST[ 'ccc_dir' ] ) ) {
            $config[ 'ccc_dir' ] = $_POST[ 'ccc_dir' ];
        }
        if( isset( $_POST[ 'popup_width' ] ) ) {
            $width = (int) $_POST[ 'popup_width' ];
            if( $width < 20 ) {
                $width = 20;
            }
            if( $width > 2000 ) {
                $width = 2000;
            }
            $config[ 'popup_width' ] = $width;
        }
        if( isset( $_POST[ 'quote_prefix' ] ) ) {
            $config[ 'quote_prefix' ] = $_POST[ 'quote_prefix' ];
        }
        if( isset( $_POST[ 'quote_suffix' ] ) ) {
            $config[ 'quote_suffix' ] = $_POST[ 'quote_suffix' ];
        }
        $config[ 'show_link_NAB' ] = (bool) $_POST[ 'show_link_NAB' ];
        $config[ 'show_link_KJV' ] = (bool) $_POST[ 'show_link_KJV' ];
        $config[ 'show_link_NIV' ] = (bool) $_POST[ 'show_link_NIV' ];
        $config[ 'show_link_Vulg' ] = (bool) $_POST[ 'show_link_Vulg' ];
        $config[ 'show_link_Greek' ] = (bool) $_POST[ 'show_link_Greek' ];
        $config[ 'show_link_Hebrew' ] = (bool) $_POST[ 'show_link_Hebrew' ];
        $config[ 'show_link_LXX' ] = (bool) $_POST[ 'show_link_LXX' ];
        $config[ 'show_link_NJB' ] = (bool) $_POST[ 'show_link_NJB' ];
        $config[ 'link_behaviour' ] = $_POST[ 'link_behaviour' ];
        
        update_option( $cathref_wp_option_name, $config );
        $cathref_notices .= __( 'Configuration saved.<br />', 'catholic-reference' );
    }
    cathref_check_texts( $config );
    ?>
    
    <?php
    if( ! empty( $cathref_notices ) ) {
    ?>
        <div class="cathref_config_notice">
        <?php
        echo $cathref_notices;
        ?>
        </div>
        <?php
    }
    ?>
    
    <div class="cathref_config">
    
    <h2>Catholic Reference Extension</h2>
    
    Version <?php echo $cathref_version; ?>
    
    <form method="POST" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    
        <div>
        Show popups when references are:
        <input type="radio" name="show_popup_on_hover" value="1" <?php
            $config[ 'show_popup_on_hover' ] ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />hovered over &nbsp;
        <input type="radio" name="show_popup_on_hover" value="0" <?php
            ( ! $config[ 'show_popup_on_hover' ] ) ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />clicked
        </div>
        
        <div>
        Popup width:
        <input type="text" name="popup_width" value="<?php echo $config[ 'popup_width' ] ?>" size="4" />pixels
        </div>
        
        <div>
        Show header in quotations:
        <input type="checkbox" name="show_quote_header" <?php
            ( $config[ 'show_quote_header' ] ) ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />
        </div>
        
        <div>
        Bible versions linked in popups:
        <?php foreach( $config as $key => $value ) {
            if( preg_match( "/^show_link_(.+)$/", $key, $matches ) ) {
                $opt = $matches[ 0 ];
                $bible = $matches[ 1 ];
                ?>
                <input type="checkbox" name="<?php echo $opt; ?>" <?php
                    ( $config[ $opt ] ) ? _e( 'checked', 'catholic-reference' ) : ''
                ?> /><?php echo $bible;
            }
        }
        ?>
        </div>
        <h3>Advanced</h3>
        
        <div>
        Douay-Rheims Bible text directory:
        <input type="text" name="drb_dir" value="<?php echo $config[ 'drb_dir' ] ?>" size="40" />
        </div>
        <div>
        Catechism of the Catholic Church text directory:
        <input type="text" name="ccc_dir" value="<?php echo $config[ 'ccc_dir' ] ?>" size="40" />
        </div>
        
        <p>
        These two pieces of HTML are used to wrap Scripture and CCC quotations.
        </p>
        <table>
        <tr>
        <td>Quote prefix:</td>
        <td><textarea name="quote_prefix" cols="50" rows="3"><?php echo $config[ 'quote_prefix' ] ?></textarea></td>
        </tr>
        <tr>
        <td>Quote suffix:</td>
        <td><textarea name="quote_suffix" cols="50" rows="3"><?php echo $config[ 'quote_suffix' ] ?></textarea></td>
        </tr>
        </table>
        
        <div>
        Links open:
        <input type="radio" name="link_behaviour" value="target" <?php
            ( $config[ 'link_behaviour' ] == 'target' ) ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />using target attribute on &lt;a&gt; &nbsp;
        <input type="radio" name="link_behaviour" value="js" <?php
            ( $config[ 'link_behaviour' ] == 'js' ) ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />using Javascript &nbsp;
        <input type="radio" name="link_behaviour" value="nil" <?php
            ( $config[ 'link_behaviour' ] == 'nil' ) ? _e( 'checked', 'catholic-reference' ) : ''
        ?> />in same window
        </div>
        
        <br />
        <input type="submit" id="cathref_submit" name="cathref_submit" value="<?php _e( 'Save Changes', 'catholic-reference' ); ?>" />
    
    </form>
    
    </div>
    <?php
}
    
function cathref_options_page_adder() {
    if( function_exists( 'add_options_page' ) ) {
        add_options_page(
            __(
                'Catholic Reference Extension',
                'catholic-reference'
            ),
            __(
                'Catholic Reference',
                'catholic-reference'
            ),
            'administrator',
            basename(__FILE__),
            'cathref_options_page'
        );
    }
}

cathref_initialize();

?>