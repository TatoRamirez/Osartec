<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 4.2
 */
final class SiteTreeStylesheetBuilder {
    /**
     * @since 4.2
     * @var object
     */
    private $plugin;

    /**
     * @since 4.2
     * @var string
     */
    private $sitemapID;

    /**
     * @since 4.2
     *
     * @param object $plugin
     * @param string $sitemap_id
     */
    public function __construct( $plugin, $sitemap_id ) {
        $this->plugin    = $plugin;
        $this->sitemapID = $sitemap_id;
    }

    /**
     * @since 4.2
     */
    public function wpWillLoadTemplate() {
        switch ( $this->sitemapID ) {
            case 'sitemap':
                exit( $this->getSitemapStylesheet() );

            case 'newsmap':
                exit( $this->getNewsmapStylesheet() );
        }
    }

    /**
     * @since 4.2
     */
    private function getSitemapStylesheet() {
        $title = __( 'Google Sitemap', 'sitetree-pro' );
        $intro = __( 'This document lists all the publicly accessible web pages you can find on this website. Although addressed to search engines, you are more than welcome to peruse it!', 'sitetree-pro' );

        $th_values = array(
            'images'  => __( 'Images', 'sitetree-pro' ),
            'lastmod' => __( 'Last Modified', 'sitetree-pro' )
        );

        return <<<XSL
<?xml version="1.0" encoding="UTF-8"?>
<!-- License and copyrights are the same as the {$this->plugin->name()} package -->
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<xsl:output method="html" doctype-system="about:legacy-compat" encoding="UTF-8" />
<xsl:template match="/">

<xsl:variable name="images" select="sitemap:urlset/sitemap:url/image:image" />

<html>
<head>
<meta charset="UTF-8" />
<meta name="robots" content="noindex" />

<title>{$title}</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CUbuntu:400,700&amp;display=swap" />

<style>
/*
 * Reset by Eric A. Meyer.
 * v2.0-modified
 * http://meyerweb.com/eric/tools/css/reset/ 
 */
html, body, h1, p, a, small, table, th, tr, td {
    border: 0;
    font-size: 100%;
    font: inherit;
    margin: 0;
    padding: 0;
    vertical-align: baseline;
}
body {
    line-height: 1;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
}

body {
    color: #333;
    font: 14px 'Open Sans', sans-serif;
    margin: 0 auto;
    max-width: 900px;
    min-width: 300px;
    padding: 30px 20px 10px;
}

h1 {
    color: #111;
    font-size: 48px;
    font-weight: 400;
    margin-bottom: 0.5em;
}

h1, th {
    font-family: 'Ubuntu', sans-serif;
}

p {
    font-size: 16px;
    line-height: 1.75em;
    margin-bottom: 1em;
}

a {
    color: #0062bb;
    text-decoration: none;
}
a:hover { 
    text-decoration: underline;
}

table {
    margin: 50px 0;
}

th {
    font-weight: 700;
    min-width: 90px;
    padding-bottom: 10px;
    text-align: left;
    vertical-align: bottom;
    width: 90px;
}
th:first-child {
    padding-left: 6px;
    width: 100%;
}

tr:nth-child(2n) {
    background: #f5f6f7;
    border-bottom: #eeedec 1px solid;
    border-top: #eeedec 1px solid;
}

td {
    line-height: 1.5em;
    padding: 5px 0;
    vertical-align: middle;
}
td:first-child {
    padding-left: 7px;
    padding-right: 30px;
    }
    td a:visited {
        color: #999;
    }

#lastmod-head {
    min-width: 150px;
    width: 150px;
}

#credit-note {
    font-size: 12px;
    text-align: center;
}
</style>
</head>
<body>
    <h1>{$title}</h1>
    <p>{$intro}</p>
    <table>
        <thead>
        <tr>
            <th>URL</th>
        <xsl:if test="\$images">
            <th>{$th_values['images']}</th>
        </xsl:if>
            <th id="lastmod-head">{$th_values['lastmod']}</th>
        </tr>
        </thead>
        <tbody>
        <xsl:for-each select="sitemap:urlset/sitemap:url"> 
            <tr>
                <xsl:variable name="url" select="sitemap:loc" />
                <td><a href="{\$url}" target="sitetree"><xsl:value-of select="sitemap:loc" /></a></td>
                
                <xsl:if test="\$images">
                    <xsl:variable name="image_count" select="count(image:image)" />
                    <xsl:choose>
                        <xsl:when test="\$image_count &gt; 0">
                            <td><xsl:copy-of select="\$image_count" /></td>
                        </xsl:when>
                        <xsl:otherwise>
                            <td>-</td>
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:if>
                
                <xsl:choose>
                    <xsl:when test="sitemap:lastmod">
                        <td><xsl:value-of select="concat(substring(sitemap:lastmod, 1,10), '&#160;&#160;@&#160;&#160;', substring(sitemap:lastmod, 12,5))" /></td>
                    </xsl:when>
                    <xsl:otherwise>
                        <td>-</td>
                    </xsl:otherwise>
                </xsl:choose>
            </tr>
        </xsl:for-each>
        </tbody>
    </table>
    {$this->getCreditNote()}
<script type="text/javascript">
//<![CDATA[
var rows = document.getElementsByTagName('tr');
    
for ( var i = 1; i < rows.length; i++ ) {
    var link = rows[i].children[0].childNodes[0].firstChild;
    
    link.data = decodeURI( link.data );
}
//]]>
</script>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
XSL;
    }

    /**
     * @since 4.2
     */
    private function getNewsmapStylesheet() {
        $title          = __( 'Google News Sitemap', 'sitetree-pro' );
        $intro          = __( 'This document lists all the news published in the last two days. Although addressed to Googlebot News, you are more than welcome to peruse it!', 'sitetree-pro' );
        $no_news_notice = __( 'There is no recently published news.', 'sitetree-pro' );

        $th_values = array(
            'news'      => __( 'News', 'sitetree-pro' ),
            'publisher' => __( 'Publisher', 'sitetree-pro' ),
            'lang'      => __( 'Language', 'sitetree-pro' ),
            'pub_date'  => __( 'Publication Date', 'sitetree-pro' )
        );

        return <<<XSL
<?xml version="1.0" encoding="UTF-8"?>
<!-- License and copyrights are the same as the SiteTree Pro package -->
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
<xsl:output method="html" doctype-system="about:legacy-compat" encoding="UTF-8" />
<xsl:template match="/">

<html>
<head>
<meta charset="UTF-8" />
<meta name="robots" content="noindex" />

<title>{$title}</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CUbuntu:400,700&amp;display=swap" />

<style>
/*
 * Reset by Eric A. Meyer.
 * v2.0-modified
 * http://meyerweb.com/eric/tools/css/reset/ 
 */
html, body, h1, p, a, small, table, th, tr, td {
    border: 0;
    font-size: 100%;
    font: inherit;
    margin: 0;
    padding: 0;
    vertical-align: baseline;
}
body {
    line-height: 1;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
}

body {
    color: #333;
    font: 14px 'Open Sans', sans-serif;
    margin: 0 auto;
    padding: 30px 20px 10px;
    width: 900px;
}

h1 {
    color: #111;
    font-size: 48px;
    font-weight: 400;
    margin-bottom: 0.5em;
}

h1, th {
    font-family: 'Ubuntu', sans-serif;
}

p {
    font-size: 16px;
    line-height: 1.75em;
    margin-bottom: 1em;
}

a {
    color: #c16200;
    text-decoration: none;
}
a:hover { 
    text-decoration: underline;
}

table,
#notice {
    margin: 50px 0;
}

#notice {
    background: #c1620030;
    color: #c16200;
    font-size: inherit;
    font-weight: 500;
    line-height: 38px;
    text-align: center;
}

th {
    font-weight: 700;
    padding-bottom: 10px;
    text-align: left;
    vertical-align: bottom;
    width: 100%;
}
th:first-child {
    padding-left: 6px;
}

#publisher-head {
    min-width: 250px;
    width: 250px; 
}

#language-head {
    min-width: 90px;
    width: 90px; 
}

#date-head {
    min-width: 150px;
    width: 150px;
}

tr:nth-child(2n) {
    background: #f7f6f5;
    border-bottom: #eeedec 1px solid;
    border-top: #eeedec 1px solid;
}

td {
    line-height: 1.5em;
    padding: 5px 0;
    vertical-align: middle;
}
td:first-child {
    padding-left: 7px;
    padding-right: 30px;
    }
    td a:visited {
        color: #999;
    }

#credit-note {
    font-size: 12px;
    text-align: center;
}
</style>
</head>
<body>
    <h1>{$title}</h1>
    <p>{$intro}</p>
    <xsl:choose>
        <xsl:when test="sitemap:urlset/sitemap:url">
            <table>
                <thead>
                <tr>
                    <th>{$th_values['news']}</th>
                    <th id="publisher-head">{$th_values['publisher']}</th>
                    <th id="language-head">{$th_values['lang']}</th>
                   <th id="date-head">{$th_values['pub_date']}</th>
                </tr>
                </thead>
                <tbody>
                <xsl:for-each select="sitemap:urlset/sitemap:url"> 
                    <tr>
                        <xsl:variable name="url" select="sitemap:loc" />
                        
                        <td><a href="{\$url}" target="sitetree"><xsl:value-of select="news:news/news:title" /></a></td>
                        <td><xsl:value-of select="news:news/news:publication/news:name" /></td>
                        <td><xsl:value-of select="news:news/news:publication/news:language" /></td>
                        <td><xsl:value-of select="concat(substring(news:news/news:publication_date, 1,10), '&#160;&#160;@&#160;&#160;', substring(news:news/news:publication_date, 12,5))" /></td>
                    </tr>
                </xsl:for-each>
                </tbody>
            </table>
        </xsl:when>
        <xsl:otherwise>
            <p id="notice">{$no_news_notice}</p>
        </xsl:otherwise>
    </xsl:choose>
    {$this->getCreditNote()}
</body>
</html>
</xsl:template>
</xsl:stylesheet>
XSL;
    }

    /**
     * @since 4.2
     */
    private function getCreditNote() {
        $link = '<a href="' . $this->plugin->pluginURI() . '">' . $this->plugin->name() . '</a>';
        $note = sprintf( __( 'Generated by %s for WordPress.', 'sitetree-pro' ), $link );

        return( '<p id="credit-note"><small>' . $note . '</small></p>' );
    }
}
?>