<?php
class Test_CheckerCase extends PHPUnit_Framework_TestCase 
{
    public function testCollectStyles() {
        $content = '
                <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

 <title>PHP: preg_match_all - Manual </title>

 <meta charset="utf-8"/>

 <link rel="shortcut icon" href="/favicon.ico" />
 <link rel="search" type="application/opensearchdescription+xml" href="http://php.net/phpnetimprovedsearch.src" title="Add PHP.net search" />
 <link rel="alternate" type="application/atom+xml" href="http://www.php.net/releases.atom" title="PHP Release feed" />
 <link rel="alternate" type="application/atom+xml" href="http://www.php.net/feed.atom" title="PHP: Hypertext Preprocessor" />

 <link rel="canonical" href="http://php.net//manual/en/function.preg-match-all.php" />
 <link rel="shorturl" href="http://php.net/preg-match-all" />

 <link rel="contents" href="http://www.php.net/index.php" />
 <link href="http://www.php.net/ref.pcre.php" rel="index"  />
 <link rel="prev" href="http://www.php.net/function.preg-last-error.php">
 <link rel="next" href="http://www.php.net/function.preg-match.php" />

 <link rel="stylesheet" type="text/css" href="/styles/reset.css" media="all" />
 <link href="/styles/theme.css?v=1375029092" media="screen" rel="stylesheet" type="text/css" />
 <link rel = "stylesheet" type="text/css" href = /styles/doc.css?v=1375029092 media="screen" >
 <LINK Rel="stylesheet" type="text/css" HREF="/styles/home.css?v=1375029092" media="screen" />
 <link rel="stylesheet" type="text/css" href=/styles/dynamic.php?v=1375029092 />

 <link rel="stylesheet" type="text/css" bad="true" />
 <!--[if lte IE 7]>
 <link rel="stylesheet" type="text/css" href="/styles/workarounds.ie7.css?v=1375029092" media="screen" />
 <![endif]-->';
        
        $checker = new Msc_Checker(new Mock_HttpClient('same_content.txt'));
        $styles = $checker->collectStyles($content);
        $this->assertCount(6, $styles);
        $this->assertEquals('/styles/doc.css', $styles[0]);
        $this->assertEquals('/styles/home.css', $styles[2]);
        $this->assertEquals('/styles/workarounds.ie7.css', $styles[5]);
    }
    
    public function testSameContent() {
        $checker = new Msc_Checker(new Mock_HttpClient('same_content.txt'));
        $this->assertEquals(false, $checker->check('http://whatever.com')->isMobile);
    }
    
    public function testIrrelevantDifferences() {
        $checker = new Msc_Checker(new Mock_HttpClient('irrelevant_differences.txt'));
        $this->assertEquals(false, $checker->check('http://whatever.com')->isMobile);
    }
    
    public function testSameStyles() {
        $checker = new Msc_Checker(new Mock_HttpClient('same_styles.txt'));
        $this->assertEquals(false, $checker->check('http://whatever.com')->isMobile);
    }
    
    public function testDifferentStyles() {
        $checker = new Msc_Checker(new Mock_HttpClient('different_styles.txt'));
        $this->assertEquals(true, $checker->check('http://whatever.com')->isMobile);
    }
    
    public function testDifferentStyleCount() {
        $checker = new Msc_Checker(new Mock_HttpClient('different_style_count.txt'));
        $this->assertEquals(true, $checker->check('http://whatever.com')->isMobile);
    }
}