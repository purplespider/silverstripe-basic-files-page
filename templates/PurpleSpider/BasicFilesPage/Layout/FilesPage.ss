<% require css("purplespider/basic-files-page: client/dist/css/basic-galleries.css") %>

<h1>$Title</h1>

<p>$Content</p>

<% if sortedFiles %>
		<ul>
	<% loop sortedFiles %>
		
	<li>
		<a href="$File.URL"><strong>$Title</strong> ($File.Size, $File.Extension)</a>
	</li>
		
	<% end_loop %>
</ul>
<% end_if %>


$Form
$PageComments