<title> - Google+ Code Indenter</title>
<script type="text/javascript">

function getTextAreaSelection(textarea) {
    var start = textarea.selectionStart, end = textarea.selectionEnd;
    return {
        start: start,
        end: end,
        length: end - start,
        text: textarea.value.slice(start, end)
    };
}

function detectPaste(textarea, callback) {
    textarea.onpaste = function() {
        var sel = getTextAreaSelection(textarea);
        var initialLength = textarea.value.length;
        window.setTimeout(function() {
            var val = textarea.value;
            var pastedTextLength = val.length - (initialLength - sel.length);
            var end = sel.start + pastedTextLength;
            callback({
                start: sel.start,
                end: end,
                length: pastedTextLength,
                text: val.slice(sel.start, end)
            });
        }, 1);
    };
}

function bin2hex (s) {
    // Converts the binary representation of data to hex  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/bin2hex
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   bugfixed by: Linuxworld
    var i, f = 0,
        a = [];
 
    s += '';
    f = s.length;
 
    for (i = 0; i < f; i++) {
        a[i] = s.charCodeAt(i).toString(16).replace(/^([\da-f])$/, "0$1");
    }
 
    return a.join('');
}

function detect_gplusized(){
var hexdata=bin2hex(document.getElementById("codearea").value);
submit_button=document.getElementById("submit_button")
if(hexdata.indexOf("2002")=="-1"){submit_button.value="Google+ize your code!";}else{submit_button.value="Revert from Google+ized code!";}


}
</script>
<img src="/res/projects/googlepluscodeindenter/header.png" alt="G+ Code Indenter" />
<div style="font-size:small";>
<div style="width:50%;float:left;margin-right:10px;">
<p>Every developer wants to <strong>share his work</strong>. </p><p>And I'm sure that every developer has sadly realized that Google+ uses to trim leading whitespaces out from posts and comments, making posted code not so easy to read or even unreadable in the case of Python code.</p>
<p>I am proud to announce the release of this funny tool with a funny name, <strong>Google+ Code Indenter</strong>, which solves the good <del>old</del> new code indenting problem.</p>
<h2>Nice, how does it work?</h2>
<p>It's simple: you paste your code in that textarea beside, then you click the button.</p>
<p>Your pasted code will be processed and <em>Google+ized</em>, and you will be able to post it in Google+ keeping original indentations.</p>
<h2>How many problems might occur?</h2>
<p><strong>At least one</strong>: a big one.</p>
<p>Since whitespaces are replaced with a kinda weird non-ASCII character, <a href="http://www.fileformat.info/info/unicode/char/2002/index.htm">&lt;en space&gt;</a>, any compiler or interpreter will <strong>fail</strong> trying to execute <em>Google+ized</em> code.</p>
<h2>How can I solve it?</h2>
<p>Problems and solutions are heads and tails of the same coin: to revert <em>Google+ized</em> code, you simply have to paste it again in textarea beside, the tool will auto-detect <em>Google+ized</em> code and will turn it into regular code :-)</p>

<div class="g-plusone" data-size="tall" data-annotation="inline"></div>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<br/>

</div>

<div onmouseover="detect_gplusized()" style="border-left: 10px solid #F7F3F0;padding-left:15px;margin-left:5px;width:40%;float:left">



<h2 style="text-align:center">Paste your code here</h2>
<?php
if(!function_exists('hex2bin'))
{
    function hex2bin($data)
    {
        $bin="";
        $i=0;
        do {
            $bin.= chr(hexdec($data{$i}.$data{($i + 1)}));
            $i+= 2;
        } while ($i < strlen($data));
        return $bin;
    }
}

if(isset($_POST['indent'])){
	$input_code=$_POST['input_code'];
	$input_code_hex=bin2hex($input_code);
	$check_e28082=strpos($input_code_hex,"e28082");

	if($check_e28082!==False){
		$output_code=str_replace("e28082","20",$input_code_hex);
		$output_code=hex2bin($output_code);
	}else{
		$input_code=explode("\n",$input_code);
		for($i=0;$i<count($input_code);$i++){
			$output_code=$output_code."\n".str_pad($input_code_trimmed=ltrim($input_code[$i]), strlen($input_code_trimmed) + 6*((strlen($input_code[$i]) - strlen($input_code_trimmed))), "&#8194", STR_PAD_LEFT);
		}
	}
}else{
	$output_code="";
}

echo '<script type="text/javascript">'

   , 'eval(detect_gplusized());'
   , '</script>';

?>
<form action="/projects/googlepluscodeindenter" method="post">
<textarea  id="codearea" onkeypress="detect_gplusized()"   name="input_code" cols="50" rows="35" style="width:100%" ><?php echo "$output_code"; ?></textarea>
<script type="text/javascript">
var textarea = document.getElementById("codearea");
detectPaste(textarea, function(pasteInfo) {

});
</script>
<input type="submit" style="font-size:large;width:100%" name="indent"  value="Google+ize your code!" id="submit_button"/>
</form>
<br/>
<img style="width:100%" src="/res/projects/googlepluscodeindenter/logo.png" alt="Logo" />
</div>

<div class="pulisci"></div>
<br/>
<p>I will turn it to a ajax-based tool as soon as I can.</p>
<p>A special thanks goes to <a href="http://beopoint.com/">&#1054;&#1075;&#1085;&#1103;&#1085; &#1062;&#1086;&#1085;&#1077;&#1074;</a> for making the original code run faster and for developing the <a href="https://chrome.google.com/webstore/detail/ipjkcpehfclkjbpadidlfahfjapkhemd">G+coder</a> Chrome extension.</p>

<p>If something goes wrong, please feedback</p>

<div style="text-align:center">
<div class="g-plus" data-href="https://plus.google.com/115859961800127275872" data-width="500" data-height="100" ></div>
</div>
</div>
<br/>
<div id="disqus_thread"></div>
<script type="text/javascript">
    var disqus_shortname = 'claudiodangelis';
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
