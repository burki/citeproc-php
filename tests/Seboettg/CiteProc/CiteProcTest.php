<?php
/*
 * This file is a part of HDS (HeBIS Discovery System). HDS is an 
 * extension of the open source library search engine VuFind, that 
 * allows users to search and browse beyond resources. More 
 * Information about VuFind you will find on http://www.vufind.org
 * 
 * Copyright (C) 2016 
 * HeBIS Verbundzentrale des HeBIS-Verbundes 
 * Goethe-Universität Frankfurt / Goethe University of Frankfurt
 * http://www.hebis.de
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

namespace Seboettg\CiteProc;


class CiteProcTest extends \PHPUnit_Framework_TestCase
{

    private $style = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<style xmlns="http://purl.org/net/xbiblio/csl" class="in-text" version="1.0" demote-non-dropping-particle="never">
  <info>
    <title>American Psychological Association 6th edition</title>
    <title-short>APA</title-short>
    <id>http://www.zotero.org/styles/apa</id>
    <link href="http://www.zotero.org/styles/apa" rel="self"/>
    <link href="http://owl.english.purdue.edu/owl/resource/560/01/" rel="documentation"/>
    <author>
      <name>Simon Kornblith</name>
      <email>simon@simonster.com</email>
    </author>
    <contributor>
      <name>Bruce D'Arcus</name>
    </contributor>
    <contributor>
      <name>Curtis M. Humphrey</name>
    </contributor>
    <contributor>
      <name>Richard Karnesky</name>
      <email>karnesky+zotero@gmail.com</email>
      <uri>http://arc.nucapt.northwestern.edu/Richard_Karnesky</uri>
    </contributor>
    <contributor>
      <name>Sebastian Karcher</name>
    </contributor>
    <contributor>
      <name> Brenton M. Wiernik</name>
      <email>zotero@wiernik.org</email>
    </contributor>
    <category citation-format="author-date"/>
    <category field="psychology"/>
    <category field="generic-base"/>
    <updated>2016-05-25T09:01:49+00:00</updated>
    <rights license="http://creativecommons.org/licenses/by-sa/3.0/">This work is licensed under a Creative Commons Attribution-ShareAlike 3.0 License</rights>
  </info>
  <locale xml:lang="en">
    <terms>
      <term name="editortranslator" form="short">
        <single>ed. &amp; trans.</single>
        <multiple>eds. &amp; trans.</multiple>
      </term>
      <term name="translator" form="short">
        <single>trans.</single>
        <multiple>trans.</multiple>
      </term>
    </terms>
  </locale>
  <macro name="container-contributors">
    <choose>
      <if type="chapter paper-conference entry-dictionary entry-encyclopedia" match="any">
        <group delimiter=", ">
          <names variable="container-author" delimiter=", ">
            <name and="symbol" initialize-with=". " delimiter=", "/>
            <label form="short" prefix=" (" text-case="title" suffix=")"/>
          </names>
          <names variable="editor translator" delimiter=", ">
            <name and="symbol" initialize-with=". " delimiter=", "/>
            <label form="short" prefix=" (" text-case="title" suffix=")"/>
          </names>
        </group>
      </if>
    </choose>
  </macro>
  <macro name="secondary-contributors">
    <choose>
      <if type="article-journal chapter paper-conference entry-dictionary entry-encyclopedia" match="none">
        <group delimiter=", " prefix=" (" suffix=")">
          <names variable="container-author" delimiter=", ">
            <name and="symbol" initialize-with=". " delimiter=", "/>
            <label form="short" prefix=", " text-case="title"/>
          </names>
          <names variable="editor translator" delimiter=", ">
            <name and="symbol" initialize-with=". " delimiter=", "/>
            <label form="short" prefix=", " text-case="title"/>
          </names>
        </group>
      </if>
    </choose>
  </macro>
  <macro name="author">
    <names variable="author">
      <name name-as-sort-order="all" and="symbol" sort-separator=", " initialize-with=". " delimiter=", " delimiter-precedes-last="always"/>
      <label form="short" prefix=" (" suffix=")" text-case="capitalize-first"/>
      <substitute>
        <names variable="editor"/>
        <names variable="translator"/>
        <choose>
          <if type="report">
            <text variable="publisher"/>
            <text macro="title"/>
          </if>
          <else>
            <text macro="title"/>
          </else>
        </choose>
      </substitute>
    </names>
  </macro>
  <macro name="author-short">
    <names variable="author">
      <name form="short" and="symbol" delimiter=", " initialize-with=". "/>
      <substitute>
        <names variable="editor"/>
        <names variable="translator"/>
        <choose>
          <if type="report">
            <text variable="publisher"/>
            <text variable="title" form="short" font-style="italic"/>
          </if>
          <else-if type="legal_case">
            <text variable="title" font-style="italic"/>
          </else-if>
          <else-if type="bill book graphic legislation motion_picture song" match="any">
            <text variable="title" form="short" font-style="italic"/>
          </else-if>
          <else-if variable="reviewed-author">
            <choose>
              <if variable="reviewed-title" match="none">
                <text variable="title" form="short" font-style="italic" prefix="Review of "/>
              </if>
              <else>
                <text variable="title" form="short" quotes="true"/>
              </else>
            </choose>
          </else-if>
          <else>
            <text variable="title" form="short" quotes="true"/>
          </else>
        </choose>
      </substitute>
    </names>
  </macro>
  <macro name="access">
    <choose>
      <if type="thesis report" match="any">
        <choose>
          <if variable="DOI" match="any">
            <text variable="DOI" prefix="http://doi.org/"/>
          </if>
          <else-if variable="archive" match="any">
            <group>
              <text term="retrieved" text-case="capitalize-first" suffix=" "/>
              <text term="from" suffix=" "/>
              <text variable="archive" suffix="."/>
              <text variable="archive_location" prefix=" (" suffix=")"/>
            </group>
          </else-if>
          <else>
            <group>
              <text term="retrieved" text-case="capitalize-first" suffix=" "/>
              <text term="from" suffix=" "/>
              <text variable="URL"/>
            </group>
          </else>
        </choose>
      </if>
      <else>
        <choose>
          <if variable="DOI">
            <text variable="DOI" prefix="http://doi.org/"/>
          </if>
          <else>
            <choose>
              <if type="webpage">
                <group delimiter=" ">
                  <text term="retrieved" text-case="capitalize-first" suffix=" "/>
                  <group>
                    <date variable="accessed" form="text" suffix=", "/>
                  </group>
                  <text term="from"/>
                  <text variable="URL"/>
                </group>
              </if>
              <else>
                <group>
                  <text term="retrieved" text-case="capitalize-first" suffix=" "/>
                  <text term="from" suffix=" "/>
                  <text variable="URL"/>
                </group>
              </else>
            </choose>
          </else>
        </choose>
      </else>
    </choose>
  </macro>
  <macro name="title">
    <choose>
      <if type="book graphic manuscript motion_picture report song speech thesis" match="any">
        <choose>
          <if variable="version" type="book" match="all">
            <!---This is a hack until we have a computer program type -->
            <text variable="title"/>
          </if>
          <else>
            <text variable="title" font-style="italic"/>
          </else>
        </choose>
      </if>
      <else-if variable="reviewed-author">
        <choose>
          <if variable="reviewed-title">
            <group delimiter=" ">
              <text variable="title"/>
              <group delimiter=", " prefix="[" suffix="]">
                <text variable="reviewed-title" font-style="italic" prefix="Review of "/>
                <names variable="reviewed-author" delimiter=", ">
                  <label form="verb-short" suffix=" "/>
                  <name and="symbol" initialize-with=". " delimiter=", "/>
                </names>
              </group>
            </group>
          </if>
          <else>
            <!-- assume `title` is title of reviewed work -->
            <group delimiter=", " prefix="[" suffix="]">
              <text variable="title" font-style="italic" prefix="Review of "/>
              <names variable="reviewed-author" delimiter=", ">
                <label form="verb-short" suffix=" "/>
                <name and="symbol" initialize-with=". " delimiter=", "/>
              </names>
            </group>
          </else>
        </choose>
      </else-if>
      <else>
        <text variable="title"/>
      </else>
    </choose>
  </macro>
  <macro name="title-plus-extra">
    <text macro="title"/>
    <choose>
      <if type="report thesis" match="any">
        <group prefix=" (" suffix=")" delimiter=", ">
          <group delimiter=" ">
            <choose>
              <if variable="genre" match="any">
                <text variable="genre"/>
              </if>
              <else>
                <text variable="collection-title"/>
              </else>
            </choose>
            <text variable="number" prefix="No. "/>
          </group>
          <group delimiter=" ">
            <text term="version" text-case="capitalize-first"/>
            <text variable="version"/>
          </group>
          <text macro="edition"/>
        </group>
      </if>
      <else-if type="post-weblog webpage" match="any">
        <text variable="genre" prefix=" [" suffix="]"/>
      </else-if>
      <else-if variable="version">
        <group delimiter=" " prefix=" (" suffix=")">
          <text term="version" text-case="capitalize-first"/>
          <text variable="version"/>
        </group>
      </else-if>
    </choose>
    <text macro="format" prefix=" [" suffix="]"/>
  </macro>
  <macro name="format">
    <choose>
      <if match="any" variable="medium">
        <text variable="medium" text-case="capitalize-first"/>
      </if>
      <else-if type="dataset" match="any">
        <text value="Data set"/>
      </else-if>
    </choose>
  </macro>
  <macro name="publisher">
    <choose>
      <if type="report" match="any">
        <group delimiter=": ">
          <text variable="publisher-place"/>
          <text variable="publisher"/>
        </group>
      </if>
      <else-if type="thesis" match="any">
        <group delimiter=", ">
          <text variable="publisher"/>
          <text variable="publisher-place"/>
        </group>
      </else-if>
      <else-if type="post-weblog webpage" match="none">
        <group delimiter=", ">
          <choose>
            <if variable="event version" type="speech motion_picture" match="none">
              <!-- Including version is to avoid printing the programming language for computerProgram /-->
              <text variable="genre"/>
            </if>
          </choose>
          <choose>
            <if type="article-journal article-magazine" match="none">
              <group delimiter=": ">
                <choose>
                  <if variable="publisher-place">
                    <text variable="publisher-place"/>
                  </if>
                  <else>
                    <text variable="event-place"/>
                  </else>
                </choose>
                <text variable="publisher"/>
              </group>
            </if>
          </choose>
        </group>
      </else-if>
    </choose>
  </macro>
  <macro name="event">
    <choose>
      <if variable="container-title" match="none">
        <choose>
          <if variable="event">
            <choose>
              <if variable="genre" match="none">
                <text term="presented at" text-case="capitalize-first" suffix=" "/>
                <text variable="event"/>
              </if>
              <else>
                <group delimiter=" ">
                  <text variable="genre" text-case="capitalize-first"/>
                  <text term="presented at"/>
                  <text variable="event"/>
                </group>
              </else>
            </choose>
          </if>
          <else-if type="speech">
            <text variable="genre" text-case="capitalize-first"/>
          </else-if>
        </choose>
      </if>
    </choose>
  </macro>
  <macro name="issued">
    <choose>
      <if type="bill legal_case legislation" match="none">
        <choose>
          <if variable="issued">
            <group prefix=" (" suffix=")">
              <date variable="issued">
                <date-part name="year"/>
              </date>
              <text variable="year-suffix"/>
              <choose>
                <if type="speech" match="any">
                  <date variable="issued">
                    <date-part prefix=", " name="month"/>
                  </date>
                </if>
                <else-if type="article-journal bill book chapter graphic legal_case legislation motion_picture paper-conference report song dataset" match="none">
                  <date variable="issued">
                    <date-part prefix=", " name="month"/>
                    <date-part prefix=" " name="day"/>
                  </date>
                </else-if>
              </choose>
            </group>
          </if>
          <else-if variable="status">
            <group prefix=" (" suffix=")">
              <text variable="status"/>
              <text variable="year-suffix" prefix="-"/>
            </group>
          </else-if>
          <else>
            <group prefix=" (" suffix=")">
              <text term="no date" form="short"/>
              <text variable="year-suffix" prefix="-"/>
            </group>
          </else>
        </choose>
      </if>
    </choose>
  </macro>
  <macro name="issued-sort">
    <choose>
      <if type="article-journal bill book chapter graphic legal_case legislation motion_picture paper-conference report song dataset" match="none">
        <date variable="issued">
          <date-part name="year"/>
          <date-part name="month"/>
          <date-part name="day"/>
        </date>
      </if>
      <else>
        <date variable="issued">
          <date-part name="year"/>
        </date>
      </else>
    </choose>
  </macro>
  <macro name="issued-year">
    <choose>
      <if variable="issued">
        <group delimiter="/">
          <date variable="original-date" form="text"/>
          <group>
            <date variable="issued">
              <date-part name="year"/>
            </date>
            <text variable="year-suffix"/>
          </group>
        </group>
      </if>
      <else-if variable="status">
        <text variable="status"/>
        <text variable="year-suffix" prefix="-"/>
      </else-if>
      <else>
        <text term="no date" form="short"/>
        <text variable="year-suffix" prefix="-"/>
      </else>
    </choose>
  </macro>
  <macro name="edition">
    <choose>
      <if is-numeric="edition">
        <group delimiter=" ">
          <number variable="edition" form="ordinal"/>
          <text term="edition" form="short"/>
        </group>
      </if>
      <else>
        <text variable="edition"/>
      </else>
    </choose>
  </macro>
  <macro name="locators">
    <choose>
      <if type="article-journal article-magazine" match="any">
        <group prefix=", " delimiter=", ">
          <group>
            <text variable="volume" font-style="italic"/>
            <text variable="issue" prefix="(" suffix=")"/>
          </group>
          <text variable="page"/>
        </group>
        <choose>
          <!--for advanced online publication-->
          <if variable="issued">
            <choose>
              <if variable="page issue" match="none">
                <text variable="status" prefix=". "/>
              </if>
            </choose>
          </if>
        </choose>
      </if>
      <else-if type="article-newspaper">
        <group delimiter=" " prefix=", ">
          <label variable="page" form="short"/>
          <text variable="page"/>
        </group>
      </else-if>
      <else-if type="book graphic motion_picture report song chapter paper-conference entry-encyclopedia entry-dictionary" match="any">
        <group prefix=" (" suffix=")" delimiter=", ">
          <choose>
            <if type="report" match="none">
              <!-- edition for report is included in title-plus-extra /-->
              <text macro="edition"/>
            </if>
          </choose>
          <choose>
            <if variable="volume" match="any">
              <group>
                <text term="volume" form="short" text-case="capitalize-first" suffix=" "/>
                <number variable="volume" form="numeric"/>
              </group>
            </if>
            <else>
              <group>
                <text term="volume" form="short" plural="true" text-case="capitalize-first" suffix=" "/>
                <number variable="number-of-volumes" form="numeric" prefix="1&#8211;"/>
              </group>
            </else>
          </choose>
          <group>
            <label variable="page" form="short" suffix=" "/>
            <text variable="page"/>
          </group>
        </group>
      </else-if>
      <else-if type="legal_case">
        <group prefix=" (" suffix=")" delimiter=" ">
          <text variable="authority"/>
          <date variable="issued" form="text"/>
        </group>
      </else-if>
      <else-if type="bill legislation" match="any">
        <date variable="issued" prefix=" (" suffix=")">
          <date-part name="year"/>
        </date>
      </else-if>
    </choose>
  </macro>
  <macro name="citation-locator">
    <group>
      <choose>
        <if locator="chapter">
          <label variable="locator" form="long" text-case="capitalize-first"/>
        </if>
        <else>
          <label variable="locator" form="short"/>
        </else>
      </choose>
      <text variable="locator" prefix=" "/>
    </group>
  </macro>
  <macro name="container">
    <choose>
      <if type="post-weblog webpage" match="none">
        <group>
          <choose>
            <if type="chapter paper-conference entry-encyclopedia" match="any">
              <text term="in" text-case="capitalize-first" suffix=" "/>
            </if>
          </choose>
          <group delimiter=", ">
            <text macro="container-contributors"/>
            <text macro="secondary-contributors"/>
            <text macro="container-title"/>
          </group>
        </group>
      </if>
    </choose>
  </macro>
  <macro name="container-title">
    <choose>
      <if type="article article-journal article-magazine article-newspaper" match="any">
        <text variable="container-title" font-style="italic" text-case="title"/>
      </if>
      <else-if type="bill legal_case legislation" match="none">
        <text variable="container-title" font-style="italic"/>
      </else-if>
    </choose>
  </macro>
  <macro name="legal-cites">
    <choose>
      <if type="bill legal_case legislation" match="any">
        <group delimiter=" " prefix=", ">
          <choose>
            <if variable="container-title">
              <text variable="volume"/>
              <text variable="container-title"/>
              <group delimiter=" ">
                <!--change to label variable="section" as that becomes available -->
                <text term="section" form="symbol"/>
                <text variable="section"/>
              </group>
              <text variable="page"/>
            </if>
            <else>
              <choose>
                <if type="legal_case">
                  <text variable="number" prefix="No. "/>
                </if>
                <else>
                  <text variable="number" prefix="Pub. L. No. "/>
                  <group delimiter=" ">
                    <!--change to label variable="section" as that becomes available -->
                    <text term="section" form="symbol"/>
                    <text variable="section"/>
                  </group>
                </else>
              </choose>
            </else>
          </choose>
        </group>
      </if>
    </choose>
  </macro>
  <macro name="original-date">
    <choose>
      <if variable="original-date">
        <group prefix="(" suffix=")" delimiter=" ">
          <!---This should be localized-->
          <text value="Original work published"/>
          <date variable="original-date" form="text"/>
        </group>
      </if>
    </choose>
  </macro>
  <citation et-al-min="6" et-al-use-first="1" et-al-subsequent-min="3" et-al-subsequent-use-first="1" disambiguate-add-year-suffix="true" disambiguate-add-names="true" disambiguate-add-givenname="true" collapse="year" givenname-disambiguation-rule="primary-name">
    <sort>
      <key macro="author"/>
      <key macro="issued-sort"/>
    </sort>
    <layout prefix="(" suffix=")" delimiter="; ">
      <group delimiter=", ">
        <text macro="author-short"/>
        <text macro="issued-year"/>
        <text macro="citation-locator"/>
      </group>
    </layout>
  </citation>
  <bibliography hanging-indent="true" et-al-min="8" et-al-use-first="6" et-al-use-last="true" entry-spacing="0" line-spacing="2">
    <sort>
      <key macro="author"/>
      <key macro="issued-sort" sort="ascending"/>
      <key macro="title"/>
    </sort>
    <layout>
      <group suffix=".">
        <group delimiter=". ">
          <text macro="author"/>
          <text macro="issued"/>
          <text macro="title-plus-extra"/>
          <text macro="container"/>
        </group>
        <text macro="legal-cites"/>
        <text macro="locators"/>
        <group delimiter=", " prefix=". ">
          <text macro="event"/>
          <text macro="publisher"/>
        </group>
      </group>
      <text macro="access" prefix=" "/>
      <text macro="original-date" prefix=" "/>
    </layout>
  </bibliography>
</style>
EOF;

    private $data = "{\"DOI\":\"\",\"ISBN\":\"\",\"ISSN\":\"\",\"URL\":\"http://www.uni-kassel.de/~seboettg/ba-thesis.pdf\",\"abstract\":\"Kollaborative Verschlagwortungssysteme bieten Nutzern die Möglichkeit zur freien Verschlagwortung von Ressourcen im World Wide Web. Sie ermöglichen dem Nutzer beliebige Ressourcen mit frei wählbaren Schlagwörtern – so genannten Tags – zu versehen (Social Tagging). Im weiteren Sinne ist Social Tagging nichts anderes als das Indexieren von Ressourcen durch die Nutzenden selbst. Dabei sind die Tag-Zuordnungen für den einzelnen Nutzer und für die gesamte Community in vielerlei Hinsicht hilfreich. So können durch Tags persönliche Ideen oder Wertungen für eine Ressource ausgedrückt werden.  Außerdem können Tags als Kommunikationsmittel von den Nutzern oder Nutzergruppen untereinander verwendet werden. Tags helfen zudem bei der Navigation, beim Suchen und beim zufälligen Entdecken von neuen Ressourcen. Das Verschlagworten der Ressourcen ist für unbedarfte Anwender eine kognitiv anspruchsvolle Aufgabe. Als Unterstützung können Tag-Recommender eingesetzt werden, die Nutzern passende Tags vorschlagen sollen.\r\n\r\nUniVideo ist das Videoportal der Universität Kassel, das jedem Mitglied der Hochschule ermöglicht Videos bereitzustellen und weltweit über das WWW abrufbar zu machen. Die bereitgestellten Videos müssen von ihren Eigentümern beim Hochladen verschlagwortet werden. Die dadurch entstehende Struktur dient wiederum als Grundlage für die Navigation in UniVideo. In dieser Arbeit werden vier verschiedene Ansätze für Tag-Recommender theoretisch diskutiert und deren praktische Umsetzung für UniVideo untersucht und bewertet. Dabei werden zunächst die Grundlagen des Social Taggings erläutert und der Aufbau von UniVideo erklärt, bevor die Umsetzung der vier einzelnen Tag-Recommender beschrieben wird. Anschließend wird gezeigt wie aus den einzelnen Tag-Recommendern durch Verschmelzung ein hybrider Tag-Recommender umgesetzt werden kann.\",\"annote\":\"\",\"author\":[{\"family\":\"Böttger\",\"given\":\"Sebastian\"}],\"citation-label\":\"bottger2012konzept\",\"collection-editor\":[],\"collection-title\":\"\",\"container-author\":[],\"container-title\":\"\",\"documents\":[{\"date\":{\"date\":2,\"day\":3,\"hours\":21,\"minutes\":18,\"month\":11,\"seconds\":51,\"time\":1449087531000,\"timezoneOffset\":-60,\"year\":115},\"fileHash\":\"eb0a7f01b54675a22ea73db949022023\",\"fileName\":\"ba-thesis.pdf\",\"md5hash\":\"43293a5595d8e5fd95504b25a8afdae0\",\"temp\":false,\"userName\":\"seboettg\"}],\"edition\":\"\",\"editor\":[],\"event-date\":{\"date-parts\":[[\"2012\",\"04\"]],\"literal\":\"2012\"},\"event-place\":\"Kassel\",\"genre\":\"Master thesis\",\"id\":\"3c2ffd52e7081b66bf420f993d9144bbseboettg\",\"interhash\":\"8fd8ce9278d61f8bd5292d7aeab9aacd\",\"intrahash\":\"3c2ffd52e7081b66bf420f993d9144bb\",\"issue\":\"\",\"issued\":{\"date-parts\":[[\"2012\",\"04\"]],\"literal\":\"2012\"},\"keyword\":\"ba-thesis bathesis folksonomy myown recommender tagging tagrecommendation thesis univideo video\",\"misc\":{\"slides\":\"http://eine-url.de/publikation.pdf\",\"pdf\":\"http://eine-url.de/publikation.pdf\"},\"note\":\"\",\"number\":\"\",\"page\":\"\",\"page-first\":\"\",\"publisher\":\"Universität Kassel\",\"publisher-place\":\"Kassel\",\"status\":\"\",\"title\":\"Konzept und Umsetzung eines Tag-Recommenders für Video-Ressourcen am Beispiel UniVideo\",\"type\":\"thesis\",\"username\":\"seboettg\",\"version\":\"\",\"volume\":\"\"}";

    /**
     * @var CiteProc
     */
    private $citeProc;

    public function setUp()
    {
        $this->citeProc = new CiteProc($this->style);
    }


    public function testBibliography()
    {
        $this->citeProc->bibliography($this->data);
        $x = "foo";
    }
}