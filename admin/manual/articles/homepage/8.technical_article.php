<div id="technical_article" class="box arrivalable">
<h1>Technical details</h1>
<h3>PHP version</h3>
<p>31337 cms needs PHP version 5.5.0 or newer in order to function properly.</p>
<h3>Statistics</h3>
<p>Each site load is registered in stats.log file by PHP script located in header.php (if statistics are enabled) in format:</p>
<p>timestamp \t ip \n</p>
<h3>Trash</h3>
<p>Each deleted article actually isn't deleted, but moved into trash. Trash directory is located in /admin/trash.</p>
<p>In order to restore files from trash or delete them permamently, you have to manually delete them (eg. via FTP server).</p>
<h3>Articles order</h3>
<p>Although it doesn't matter for internal articles, order of homepage articles is crucial. On homepage articles are displayed in an alphabetical order, thats why, a 'sort string' is added right before an article's name to a newly created article's file. It isn't constant for any article and it could be reassiged when order of articles is changed.</p>
<h3>JS/CSS files loading</h3>
<p>Javascript and CSS files are automatically loaded. First CSS files (/css directory) are loaded, then Javascript libraries (/js_lib directory) and Javascript files (/js directory) at the end.</p>
<h3>CSS variables</h3>
<p>are stored in /css/_vars.css file. Feel free to add your own variables. If your variables starts with '--color' and their value start with '#', 'rgb' or 'rgba', they will be automatically added into 'Colors' section under 'Customization' tab in administrator panel.</p>
<h3>JS files description</h3>
<table>
<tbody>
<tr>
<td>/js/_functions.js</td>
<td>basic functions; actually there's one - 'isMobile' which tells if a site is viewed on a mobile device</td>
</tr>
<tr>
<td>/js/_style.js</td>
<td>some style tweaks</td>
</tr>
<tr>
<td>/js/1337.js</td>
<td>if enabled, converts whole site into 1337 site</td>
</tr>
<tr>
<td>/js/anim.js</td>
<td>various animations of divs</td>
</tr>
<tr>
<td>/js/changeSite.js</td>
<td>changes site using animations</td>
</tr>
<tr>
<td>/js/header.js</td>
<td>handles header slide show if enabled</td>
</tr>
<tr>
<td>/js/scroll.js</td>
<td>scrolls into specified homepage article using PageScroll2id library, if article cannot be found at currently viewed site (when it is not a homepage), it changes currently displayed article into new one without scrolling</td>
</tr>
</tbody>
</table>
</div>