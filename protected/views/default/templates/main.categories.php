<!-- ****************************************************** list categories with number of books ************************************************************ -->
<h3>Categories</h3>
<ul class="category">
<?php foreach ($categories as $key => $data) : ?>
    <li><a href="categories/<?php echo $urlCategories[$data['categoryId']]; ?>"><?php echo $data['category']; ?> 
            (<?php echo $data['booksNumber']; ?>)</a></li>
<?php endforeach; ?>    
</ul>
