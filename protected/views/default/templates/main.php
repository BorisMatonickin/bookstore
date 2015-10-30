<!-- ***************************************************************** products on main page *************************************************************** -->
	<div class="products">
        <?php if (isset($flashMessage)) { echo $flashMessage; } ?>
		<h3>Featured Products</h3>
		<ul>
            <?php foreach ($products as $key => $data) : ?>
			<li>
				<div class="product">
                    <a href="products/view/<?php echo $urlProducts[$data['book_id']]; ?>" class="info">
						<span class="holder">
							<img src="protected/uploads/product-images/<?php echo $data['image']; ?>" alt="" />
							<span class="book-name"><?php echo $data['title']; ?></span>
							<span class="author"><?php echo $data['authorName']; ?></span>
						</span>
					</a>
					<a href="add-product/<?php echo $data['book_id']; ?>" class="buy-btn">BUY NOW <span class="price"><span class="low">$</span><?php echo $data['price']; ?></span></a>
                    <span class="stars" id="stars-index"><?php echo $data['averageRating']; ?></span>
				</div>
			</li>
            <?php endforeach; ?>
		</ul>
	</div>
	<div class="cl">&nbsp;</div>
    
<!-- ********************************************************** the most popular products slider ********************************************************** -->
	<div id="best-sellers">
		<h3>Most Popular</h3>
		<ul>
            <?php foreach ($mostPopularProducts as $bookId => $data) : ?>
			<li>
				<div class="product">
					<a href="products/view/<?php echo $urlProducts[$data['book_id']]; ?>">
						<img src="protected/uploads/product-images/<?php echo $data['image']; ?>" alt="" />
						<span class="book-name"><?php echo $data['title']; ?></span>
						<span class="author"><?php echo $data['authorName']; ?></span>
						<span class="price"><span class="low">$</span><?php echo $data['price']; ?></span>
					</a>
				</div>
			</li>
            <?php endforeach; ?>
		</ul>
	</div>