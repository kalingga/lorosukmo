<?php

/**
 *  A PHP class to draw vertical bar graphs.
 *
 *  This class draws vertical graphs only by using HTML and CSS. No requirement for any external graphic library
 *  such as GD
 *
 *  Simple and grouped bars can be created. You can change everything regarding the looks as the output is template
 *  driven. On the fly, you can change the size of graph, the color of all or individual bars, you can add labels,
 *  title, footnote or customize the CSS style of all the elements.
 *
 *  One of the finest features of this class is that you are not anymore restricted to specify the width and/or height
 *  of your bar in pixels! You can also specify it in percents!
 *
 *  The output looks the same way in all major browsers.
 *
 *  See the documentation for more info.
 *
 *  Read the LICENSE file, provided with the package, to find out how you can use this PHP script.
 *
 *  If you don't find this file, please write an email to noname at nivelzero dot ro and you will be sent a copy of the license file
 *
 *  For more resources visit {@link http://stefangabos.blogspot.com}
 *
 *  @author     Stefan Gabos <ix@nivelzero.ro>
 *  @version    1.0 (last revision: November 11, 2006)
 *  @copyright  (c) 2006 - 2007 Stefan Gabos
 *  @package    HTMLGraph
 *  @example    example1.php
 *  @example    example2.php
 *  @example    example3.php
 */

error_reporting(E_ALL);

class HTMLGraph
{

    /**
     *  Spacing between BarPlot objects (in pixels)
     *
     *  Default is 10
     *
     *  @var    integer
     */
    var $plotSpacing;
    
    /**
     *  Title of the graph
     *
     *  This is an {@link HTMLGraph_Text} object
     *
     *  @var object
     */
    var $title;

    /**
     *  Footnote of the graph
     *
     *  This is an {@link HTMLGraph_Text} object
     *
     *  @var object
     */
    var $footnote;
    
    /**
     *  Template folder to use
     *  Note that only the folder of the template you wish to use needs to be specified. Inside the folder
     *  you <b>must</b> have the <b>template.xtpl</b> file which will be automatically used
     *
     *  default is "default"
     *
     *  @var   string
     */
    var $template;
    
    /**
     *  In case of an error read this property's value to find out what went wrong
     *
     *  possible error values are:
     *
     *  - 1 the XTemplate class could not be found
     *  - 2 the template file could not be found
     *
     *  default is 0
     *
     *  @var integer
     */
    var $error;

    /**
     *  Initializes the graph.
     *
     *  @param mixed    $width          The width of the graph. Can be a value in pixels or percentual.
     *
     *  @param mixed    $height         The height of the graph. Can be a value in pixels or percentual.
     *
     *  @param string   $titleCaption   (optional) Title of the graph.
     *
     *  @return void
     */
    function HTMLGraph($width, $height, $titleCaption = "")
    {
    
        // initializes some variables
        global $HTMLGraph_maxValue;
        global $HTMLGraph_totalValues;

        // default values for the graph's properties
        // we do this so that the script will also work in PHP 4
        $this->plotSpacing = 10;
        $this->objects = array();
        $this->template = "default";
        $this->error = 0;

        // get the absolute path of the class. any further includes rely on this
        // and (on a windows machine) replace \ with /
        $this->absolutePath = preg_replace("/\\\/", "/", dirname(__FILE__));

        // get the relative path of the class. ( by removing $_SERVER["DOCUMENT_ROOT"] from the it)
        // any HTML reference (to scripts, to stylesheets) in the template file should rely on this
        $this->relativePath = preg_replace("/".preg_replace("/\//", "\/", $_SERVER["DOCUMENT_ROOT"])."/i", "", $this->absolutePath);

        // if graph width is specified as percents
        if (strpos($width, "%") !== false) {
        
            // extract the numeric part of width
            $this->graphWidth = substr($width, 0, strpos($width, "%"));
            // assign measurement unit
            $this->graphWidthMeasureUnit = "%";
            
        // if graph width is specified as pixels
        } else {
        
            // assign the numeric part of width
            $this->graphWidth = $width;
            // assign measurement unit
            $this->graphWidthMeasureUnit = "px";
            
        }
        
        // if graph height is specified as percents
        if (strpos($height, "%") !== false) {
        
            // extract the numeric part of height
            $this->graphHeight = substr($height, 0, strpos($height, "%"));
            // assign measurement unit
            $this->graphHeightMeasureUnit = "%";
            
        // if graph height is specified as pixels
        } else {
        
            // assign the numeric part of height
            $this->graphHeight = $height;
            // assign measurement unit
            $this->graphHeightMeasureUnit = "px";
            
        }
        
        // create the title object and assign the caption
        $this->title = & new HTMLGraph_Text($titleCaption);
        
        // create the footnote object
        $this->footnote = & new HTMLGraph_Text();

    }
    
    /**
     *  Ads an {@link HTMLGraph_BarPlot} object or an {@link HTMLGraph_BarPlotGroup} object to the graph for displaying
     *
     *  @param  object  $object     An {@link HTMLGraph_BarPlot} object or an {@link HTMLGraph_BarPlotGroup} object
     *
     *  @return void
     */
    function add($object)
    {
    
        // if $object is indeed an object and is of a valid type
        if (is_object($object) && (strtolower(get_class($object)) == "htmlgraph_barplot" || strtolower(get_class($object)) == "htmlgraph_barplotgroup")) {
        
            // add it to the graph
            $this->objects[] = $object;
            
        }
        
    }
    
    /**
     *  Outputs the graph as HTML
     *
     *  @param  boolean $returnHTML     (optional)  If set to TRUE the generated output will be returned instead of
     *                                  being outputted to the screen
     *
     *                                  Default is FALSE
     *
     *  @return boolean     TRUE on success or FALSE on error.
     *
     *                      If false is returned check the {link @error} property to see what went wrong
     */
    function render($returnHTML = false)
    {
    
        global $HTMLGraph_totalValues;
        global $HTMLGraph_maxValue;
        
        $type = "vertical";

        // if the xtemplate class is not already included
        if (!class_exists("XTemplate")) {

            // if the file exists
            if (file_exists($this->absolutePath."/includes/class.xtemplate.php")) {

                // include the xtemplate class
                require_once $this->absolutePath."/includes/class.xtemplate.php";

            // if the file does not exists
            } else {

                // save the error level and stop the execution of the script
                $this->error = 1;
                return false;

            }

        }

        // if template file does not exists
        if (!file_exists($this->absolutePath."/templates/".$this->template."/template.xtpl")) {
        
            // save the error level and stop the execution of the script
            $this->error = 2;
            return false;
        
        }
        
        // create a new XTemplate object using the specified template
        $xtpl = new XTemplate($this->absolutePath."/templates/".$this->template."/template.xtpl");

        // assign relative path to the template folder
        // any HTML reference (to scripts, stylesheets) in the template file should rely on this
        $xtpl->assign("templatePath", $this->relativePath."/templates/".$this->template."/");

        // assign graph's width related information
        $xtpl->assign("graphWidth", $this->graphWidth);
        $xtpl->assign("graphWidthMeasurementUnit", $this->graphWidthMeasureUnit);

        // assign graph's height related information
        $xtpl->assign("graphHeight", $this->graphHeight);
        $xtpl->assign("graphHeightMeasurementUnit", $this->graphHeightMeasureUnit);

        // assign spacing between BarPlots
        $xtpl->assign("plotSpacing", $this->plotSpacing);
        
        // the first BarPlot is the first
        $isFirstPlot = true;
        
        // initialize the total values counter
        $HTMLGraph_totalValues = 0;
        // initialize the maximum value counter
        $HTMLGraph_maxValue = 0;
        // initialize the number of the bars
        $HTMLGraph_totalBarsNr = 0;
        
        // iterates through the obhects of the graph
        foreach ($this->objects as $object) {
        
            // if object is of HTMLGraph_BarPlotGroup type
            if (strtolower(get_class($object)) == "htmlgraph_barplotgroup") {

                // iterate throught the plots
                foreach ($object->plots as $plot) {

                    // iterate through the plots' bars
                    foreach ($plot->addedBars as $bar) {

                        // increase the counter of bars number
                        $HTMLGraph_totalBarsNr++;

                        // if the value of the bar is greater than the maximum value found so far
                        if ($bar->barValue > $HTMLGraph_maxValue) {

                            // make the value be the maximum value
                            $HTMLGraph_maxValue = $bar->barValue;

                        }

                        // add bar's value to the total values
                        $HTMLGraph_totalValues += $bar->barValue;

                    }

                }
            
            // if object is of HTMLGraph_BarPlot type
            } else {
            
                // iterate through the plots' bars
                foreach ($object->addedBars as $bar) {

                    // increase the counter of bars number
                    $HTMLGraph_totalBarsNr++;

                    // if the value of the bar is greater than the maximum value found so far
                    if ($bar->barValue > $HTMLGraph_maxValue) {

                        // make the value be the maximum value
                        $HTMLGraph_maxValue = $bar->barValue;

                    }
                    
                    // add bar's value to the total values
                    $HTMLGraph_totalValues += $bar->barValue;
                    
                }

            }

        }

        // assign the bar size, in percent
        $xtpl->assign("barSize", @floor(100 / $HTMLGraph_totalBarsNr));
        
        // iterate through the objects passed to the graph
        foreach ($this->objects as $object) {
        
            // if object is of HTMLGraph_BarPlotGroup type
            if (strtolower(get_class($object)) == "htmlgraph_barplotgroup") {

                // call the render method which will create the right BarPlot objects
                // and put them in the $HTMLGraph_groupedPlots global variable
                $object->render();
                
                // read the $HTMLGraph_groupedPlots global variable
                global $HTMLGraph_groupedPlots;
                
                // iterate through the BarPlots in $HTMLGraph_groupedPlots
                foreach ($HTMLGraph_groupedPlots as $plot) {

                    // call the render method for each
                    $plot->render($xtpl, $type, $isFirstPlot);
                    
                    // the next BarPlot is no more the first
                    $isFirstPlot = false;

                }

            // if object is of HTMLGraph_BarPlot type
            } else {
        
                // call the render method of it
                $object->render($xtpl, $type, $isFirstPlot);

                // the next BarPlot is no more the first
                $isFirstPlot = false;
            
            }
            
        }
        
        // wrap up bars display according to the graph's type
        $xtpl->parse("main.".$type);

        // title of graph
        $xtpl->assign("title", $this->title->caption);
        $xtpl->assign("titleCustomStyle", $this->title->_customStyle());
        $xtpl->parse("main.title");

        // footnote of graph
        $xtpl->assign("footnote", $this->footnote->caption);
        $xtpl->assign("footnoteCustomStyle", $this->footnote->_customStyle());
        $xtpl->parse("main.footnote");

        // wrap up graph display
        $xtpl->parse("main");

        // if result is to be returned instead of being outputted to the screen
        if ($returnHTML) {
        
            // return the result
            return $xtpl->text("main");

        } else {
        
            // output the graph
            $xtpl->out("main");
            
        }
    
    }

}

/**
 *  Groups together bars of same indices from different {@link HTMLGraph_BarPlot} objects
 */
class HTMLGraph_BarPlotGroup
{

    /**
     *  keeps track of plots added for grouping
     *
     *  @var    array
     *
     *  @access private
     */
    var $plots;
    
    /**
     *  Constructor of the class
     *
     *  @access private
     */
    function HTMLGraph_BarPlotGroup()
    {

        $this->plots = array();

    }

    /**
     *  Adds a {@link HTMLGraph_BarPlot} object for grouping
     *
     *  @param  object  $plot   An existing {@link HTMLGraph_BarPlot} object to be added for grouping
     */
    function add($plot)
    {
    
        // ads the object to the array
        $this->plots[] = $plot;

    }

    /**
     *  Groups the bars with the same indices from different {@link HTMLGraph_BarPlot} objects
     *
     *  @return void
     *
     *  @access private
     */
    function render()
    {

        // makes this variable global so that can be read by the HTMLGraph object
        // this variable holds the generated BarPlot objects
        global $HTMLGraph_groupedPlots;
        
        // initialize the variable as an empty array
        $HTMLGraph_groupedPlots = array();
    
        // iterate through the available BarPlot objects
        foreach ($this->plots as $plotObj) {

            $counter = 0;
            
            // iterate through the plot's bars
            foreach ($plotObj->addedBars as $barObj) {

                // if an entry in the HTMLGraph_groupedPlots array with the "counter" index does not exists
                if (!isset($HTMLGraph_groupedPlots[$counter])) {
                
                    // add entry to array and add a newly create BarPlot object to it
                    $HTMLGraph_groupedPlots[$counter] = & new HTMLGraph_BarPlot();
                    
                }

                // add current Bar object's properties to the addedBars property of the BarPlot object
                $HTMLGraph_groupedPlots[$counter]->addedBars[] = $barObj;

                $counter++;
                
            }

        }
        
    }

}

/**
 *  Serves as canvas for bars
 */
class HTMLGraph_BarPlot
{

    /**
     *  The spacing between bars (in pixels)
     *
     *  Default is 5
     *
     *  @var integer
     */
    var $barSpacing;
    
    /**
     *  To what reference should the size of the bars be calculated
     *
     *  Possible values are
     *
     *      -   <b>local</b> when the bars are drawn according to what percent their value is representing of
     *          the total values in the plot where the bar is located
     *
     *      -   <b>global</b> when the bars are drawn according to what percent their value is representing of the
     *          maximum value of all the bars of the graph
     *
     *  Default is "global"
     *
     *  @var    string
     */
    var $barReference;

    /**
     *  A child object of {@link HTMLGraph_BarPlot} object and which is of {@link HTMLGraph_Bar} type and that is
     *  automatically created when a new BarPlot object is instantiated
     *
     *  All the bars added to the BarPlot object will have their default properties inherited from this object
     *
     *  @var object
     */
    var $bars;

    /**
     *  A child object of {@link HTMLGraph_BarPlot} object and which is of {@link HTMLGraph_Text} type and that is
     *  automatically created when a new BarPlot object is added to the BarPlot object
     *
     *  All the values added to the BarPlot object (by adding a new {@link HTMLGraph_Bar} object) will have their default
     *  properties inherited from this object
     *
     *  @var object
     */
    var $values;

    /**
     *  A child object of {@link HTMLGraph_BarPlot} object and which is of {@link HTMLGraph_Text} type and that is
     *  automatically created when a new BarPlot object is added to the BarPlot object
     *
     *  All the labels added to the BarPlot object (by adding a new {@link HTMLGraph_Bar} object) will have their default
     *  properties inherited from this object
     *
     *  @var object
     */
    var $labels;

    /**
     *  Array with pointers to the bars added to the BarPlot object
     *
     *  @access private
     */
    var $addedBars;

    /**
     *  Constructor of the class
     *
     *  @access private
     */
    function HTMLGraph_BarPlot($label = "")
    {

        // initializes some variables used by the class
        $this->addedBars = array();

        // default values for BarPlot's properties
        $this->barSpacing = 2;
        $this->barReference = "global";
        
        // instantiate the "bars" object
        $this->bars = & new HTMLGraph_Bar();

        // instantiate the "values" object
        $this->values = & new HTMLGraph_Text();

        // instantiate the "labels" object
        $this->labels = & new HTMLGraph_Text();

        // instantiate the "label" object - this is the BarPlot's label
        $this->label = & new HTMLGraph_Text($label);

    }

    /**
     *  Creates one or more new {@link HTMLGraph_Bar} objects and adds them to the BarPlot object
     *
     *  If a single value is specified (not an array), through the returned pointer you can alter the properties of
     *  the bar, the properties of bar's label through the bar's <b>label</b> object (of {@link HTMLGraph_Text} type)
     *  and the properties of the bar's value label through the <b>value</b> object, (also of {@link HTMLGraph_Text} type)
     *
     *  @param  double  $value  The value(s) to be represented by the bar(s)
     *
     *                          Can be either a single value or an array of values
     *
     *  @param  string  $label  (optional) Label(s) to display with the bar(s)
     *
     *                          Can be either a single value or an array of values
     *
     *  @param  string  $color  (optional) The color(s) the bar(s) to be displayed in.
     *
     *                          Can be any valid hexadecimal, named or rgb color accepted by HTML
     *
     *                          If not specified, the color set to the BarPlot {@link bars} child object
     *                          is taken (which, by default, is the color set by the template file)
     *
     *                          Can be either a single value or an array of values
     *
     *  @return mixed   pointer to the newly created bar object if a single object is specified or void
     *                  if an array of values is specified
     */
    function add($value, $label = "", $color = "", $style = "")
    {
    
        // if value is specified as an array
        if (is_array($value)) {

            $counter = 0;

            // iterate through the specified values
            foreach ($value as $val) {

                // the cloning of objects differs in PHP 5
                // so if PHP's version is lower than 5
                if (version_compare(phpversion(), '5.0') < 0) {
                    // then clone an object like this
                    $newObj = $this->bars;
                    $newObj->value = $this->values;
                    $newObj->label = $this->labels;
                // if is PHP 5+ that we're talking about
                } else {
                    // then clone an object like this
                    $newObj = clone($this->bars);
                    $newObj->value = clone($this->values);
                    $newObj->label = clone($this->labels);
                }

                // assign the value the bar to represent
                $newObj->barValue = (double)$val;
                
                // assign the value's caption
                $newObj->value->caption = (double)$val;

                // if label is specified
                if ($label != "") {

                    // if label is specified as an array
                    if (is_array($label)) {
                        // if an index equal to the current counter exists
                        if (array_key_exists($counter, $label)) {
                            // assign the label with the current index to the bar
                            $newObj->label->caption = $label[$counter];
                        }
                    // if not array
                    } else {
                        // assign specified label to the bar
                        $newObj->label->caption = $label;
                    }

                }

                // if color is specified
                if ($color != "") {
                
                    // if color is specified as an array
                    if (is_array($color)) {
                        // if an index equal to the current counter exists
                        if (array_key_exists($counter, $color)) {
                            // assign the color with the current index to the bar
                            $newObj->color = $color[$counter];
                        }
                    // if not array
                    } else {
                        // assign specified color to the bar
                        $newObj->color = $color;
                    }
                    
                }

                // if style is specified
                if ($style != "") {
                
                    // if style is specified as an array
                    if (is_array($style)) {
                        // if an index equal to the current counter exists
                        if (array_key_exists($counter, $style)) {
                            // assign the style with the current index to the bar
                            $newObj->style = $style[$counter];
                        }
                    // if not array
                    } else {
                        // assign specified style to the bar
                        $newObj->style = $style;
                    }

                }

                // add bar to the to the array of bars
                $this->addedBars[] = $newObj;

                $counter++;

            }

        // if value is not specified as an array
        } else {
    
            // the cloning of objects differs in PHP 5
            // so if PHP's version is lower than 5
            if (version_compare(phpversion(), '5.0') < 0) {
                // then clone an object like this
                $newObj = $this->bars;
                $newObj->value = $this->values;
                $newObj->label = $this->labels;
            // if is PHP 5+ that we're talking about
            } else {
                // then clone an object like this
                $newObj = clone($this->bars);
                $newObj->value = clone($this->values);
                $newObj->label = clone($this->labels);
            }

            // assign the value the bar to represent
            $newObj->barValue = (double)$value;

            // assign the value's caption
            $newObj->value->caption = (double)$value;

            // if label is specified
            if ($label != "") {
                // assign the caption for the bar's label
                $newObj->label->caption = $label;
            }

            // if color is specified
            if ($color != "") {
                // assign specified color to the bar
                $newObj->color = $color;
            }

            if ($style != "") {
                // assign specified style to the bar
                $newObj->style = $style;
            }

            // add bar to the to the array of bars
            $this->addedBars[] = $newObj;

            // returns a pointer to the newly created object
            return $newObj;
            
        }

    }

    /**
     *  Renders the BarPlot object as HTML
     *
     *  @param  pointer     $xtpl           pointer to the XTemplate object instantiated by HTMLGraph's "render" method
     *
     *  @param  string      $type           (optional) which type of bars to be drawn. "horizontal" or "vertical"
     *
     *                                      default is "vertical"
     *
     *  @param  boolean     $isFirstPlot    when this is FALSE a spacing will be placed in front of the plot in
     *                                      order to separate it from a previous plot
     *
     *                                      default is TRUE
     *
     *  @return void
     *
     *  @access private
     */
    function render(&$xtpl, $type = "vertical", $isFirstPlot = true)
    {
    
        global $HTMLGraph_maxValue;
        global $HTMLGraph_totalValues;
        
        // assign bar spacing
        $xtpl->assign("barSpacing", $this->barSpacing."px");

        // wheather or not the current plot was already delimited by a previous one
        $plotDelimited = false;

        // iterate through the plot's bars
        foreach ($this->addedBars as $bar) {

            // if bar size is to be calculated relatively to the sum of the values in the plot
            if ($this->barReference == "local") {
            
                // calculate it
                @$solidSize = $bar->barValue * 100 / $HTMLGraph_totalValues;
                
            // if bar size is to be calculated relatively to the maximum value in all the graph
            } else {
            
                // calculate it
                @$solidSize = $bar->barValue * 100 / $HTMLGraph_maxValue;
                
            }

            // assign the "blank" part of the bar
            $xtpl->assign("blankSize", floor(100 - $solidSize));

            // assign the "solid" part of the bar
            $xtpl->assign("solidSize", ceil($solidSize));

            $color = "";

            // if bar color is specified
            if ($bar->color != "") {
                // add it to the bar's custom style
                $color = ";background-color:".$bar->color;
            }

            // add custom style
            $bar->style = $bar->_customStyle().$color;

            // if custom style is defined for the bar
            if ($bar->style != "") {
            
                // assign custom style
                $xtpl->assign("barCustomStyle", $bar->_customStyle());
                
            // if no custom style is defined
            } else {
            
                // empty this string because if not it will have the style of the previous bar
                $xtpl->assign("barCustomStyle", "");
                
            }

            // assign the label of the bar
            $xtpl->assign("label", $bar->label->caption);

            // if custom style is defined for the label of the bar
            if ($bar->label->style != "") {
            
                $xtpl->assign("labelCustomStyle", $bar->label->_customStyle());
                
            // if no custom style is defined for the label of the bar
            } else {
            
                // empty this string because if not it will have the style of the previous label
                $xtpl->assign("labelCustomStyle", "");
                
            }

            // assign the value to be displayed for current bar
            $xtpl->assign("value", $bar->value->caption);

            // if custom style is defined for the value label
            if ($bar->value->style != "") {

                $xtpl->assign("valueCustomStyle", $bar->value->_customStyle());

            // if no custom style is defined for the value label
            } else {

                // empty this string because if not it will have the style of the previous value label
                $xtpl->assign("valueCustomStyle", "");

            }

            // parse each bar according to type
            $xtpl->parse("main.".$type.".bar");
            
            // if this plot is not the first one and it wasn't yet delimited
            if (!$isFirstPlot && !$plotDelimited) {
            
                // render the plot delimiter at labels level and below
                $xtpl->parse("main.".$type.".label.plotDelimiter");
                // mark plot as delimited
                $plotDelimited = true;

            }

            // wrap up parsing of bar's label
            $xtpl->parse("main.".$type.".label");

        }

        // assign the number of bars in plot
        $xtpl->assign("barCount", count($this->addedBars));

        // if this is not the first plot
        if (!$isFirstPlot) {

            // render the plot delimiter at header level and below (but only until the labels level)
            $xtpl->parse("main.".$type.".header.plotDelimiter");

        }

        // wrap up parsing of header
        $xtpl->parse("main.".$type.".header");

        // assign the plot's label
        $xtpl->assign("plotLabel", $this->label->caption);
        
        // parse plot's label
        $xtpl->parse("main.".$type.".plotLabel");

    }

}

/**
 *  A generic bar class.
 *
 *  Every bar of the graph is an instance of this class therefore,
 *  for every bar of the graph, you can access the properties of this class
 *
 *  <b> This class is not to be instantiated from outside! It is used internally!</b>
 */

class HTMLGraph_Bar
{

    /**
     *  The value to be represented by the bar
     *
     *  @var double
     *
     *  @access private
     */
    var $barValue;

    /**
     *  The color the bar to be displayed in
     *
     *  Can be any valid hexadecimal, named or rgb color accepted by HTML
     *
     *  @var string
     */
    var $color;

    /**
     *  Additional CSS styling to be applied to the bar
     *
     *  If not specified, the text will be rendered as specified by the template and CSS stylesheet file used by the graph
     *
     *  @var string
     */
    var $style;

    /**
     *  Constructor of the class
     *
     *  Initializes bar's properties
     *
     *  @param  double      $value  (optional) The value to be represented by the bar
     *
     *  @param  string      $color  (optional) The color the bar to be displayed in.
     *
     *                              Can be any valid hexadecimal, named or rgb color accepted by HTML
     *
     *                              If not specified, the default color from the template will be used
     *
     *  @param  string  $style      (optional) Additional CSS styling to be applied to the text
     *
     *                              If not specified, the text will be rendered as specified by the template and
     *                              CSS stylesheet file used by the graph
     *
     *  @access private
     *
     *  @return void
     */
    function HTMLGraph_Bar($value = "", $color = "", $style = "")
    {

        // assign default properties
        $this->barValue = $value;
        $this->color = $color;
        $this->style = $style;

    }

    /**
     *  This function only cuts ";" from the beginning and the end of the user defined style
     *
     *  @access private
     */
    function _customStyle()
    {
        return trim($this->style, "\x20, ;");
    }

}

/**
 *  A generic text class.
 *
 *  Every string of the graph is an instance of this class therefore,
 *  for every string of the graph, you can access the properties of this class
 *
 *  <b> This class is not to be instantiated from outside! It is used internally!</b>
 */

class HTMLGraph_Text
{

    /**
     *  The string to be displayed
     *
     *  @var string
     */
    var $caption;

    /**
     *  Additional CSS styling to be applied to the string
     *
     *  If not specified, the text will be rendered as specified by the template and CSS stylesheet file used by the graph
     *
     *  @var string
     */
    var $style;

    /**
     *  Constructor of the class
     *
     *  Initializes text's properties
     *
     *  @param  string  $caption    (optional) The string to be displayed
     *
     *  @param  string  $style      (optional) Additional CSS styling to be applied to the text
     *
     *                              If not specified, the text will be rendered as specified by the template and
     *                              CSS stylesheet file used by the graph
     *
     *  @access private
     *
     *  @return void
     */
    function HTMLGraph_Text($caption = "", $style = "")
    {

        // assign default properties
        $this->caption = $caption;
        $this->style = $style;

    }
    
    /**
     *  This function only cuts ";" from the beginning and the end of the user defined style
     *
     *  @access private
     */
    function _customStyle()
    {
        return trim($this->style, "\x20, ;");
    }

}

?>
