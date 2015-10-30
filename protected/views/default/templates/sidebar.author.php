<!-- ***************************************************************** short author info ********************************************************************* -->
<div id="sidebar">
    <img src="protected/uploads/author-images/<?php echo $authorInfo[$author]['image']; ?>" alt ="" width="190" height="250" />
    <p>Born: in <?php echo $authorInfo[$author]['bornIn']; ?></p>
    <p>Gender: <?php echo $authorInfo[$author]['gender']; ?></p>
    <p>Website: <a href="http://<?php echo $authorInfo[$author]['website']; ?>"><?php echo $authorInfo[$author]['website']; ?></a></p>
    <p>Category: <a href="categories/<?php echo str_replace(' ', '-', $authorInfo[$author]['category']); ?>"><?php echo $authorInfo[$author]['category']; ?></a></p>
</div>

<!-- ***************************************************************** main page content ********************************************************************** -->
<div id="content">
    