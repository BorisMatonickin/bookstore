<!-- ******************************************************************* main sidebar *********************************************************************** -->
	<div id="sidebar">
            <ul class="categories">
                <li>
                    <a href="categories"><h4>Categories</h4></a>
                    <ul>
                    <?php foreach ($sidebarCategories as $key => $data) : ?>
                        <li><a href="categories/<?php echo $urlCategories[$data['cat_id']]; ?>"><?php echo $data['category']; ?></a></li>
                    <?php endforeach; ?>    
                    </ul>
                </li>
                <li>
                    <a href="authors"><h4>Authors</h4></a>
                    <ul>
                    <?php foreach($sidebarAuthors as $key => $data) : ?>    
                        <li><a href="authors/<?php echo $urlAuthors[$data['author_id']]; ?>"><?php echo $data['author']; ?></a></li>
                    <?php endforeach; ?>   
                    </ul>
                </li>
            </ul>
	</div>

<!-- **************************************************************** main page content ********************************************************************** -->
    <div id="content">
