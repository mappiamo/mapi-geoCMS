<div class="navbar-wrapper">
	<div class="container">
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"><img src="media/images/mappiamo.png" alt="#mappiamo"/></a>
				</div>
				<div class="navbar-collapse collapse">
					<?php $this->widget('menu', array(4, 'nav navbar-nav')); ?>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sample content <b class="caret"></b></a>
							<?php $this->widget('menu', array(1, 'dropdown-menu')); ?>
						</li>
					</ul>
					<!-- <ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Map control <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#">
										<label class="checkbox-inline">
											<input type="checkbox" name="mmap_category[]" value="10"> Cities (Population ~5000)
										</label>
									</a>
								</li>
								<li>
									<a href="#">
										<label class="checkbox-inline">
											<input type="checkbox" name="mmap_category[]" value="8"> Cities (Population ~30000)
										</label>
									</a>
								</li>
								<li>
									<a href="#">
										<label class="checkbox-inline">
											<input type="checkbox" name="mmap_category[]" value="9" checked="checked"> Cities (Population
											~100000)
										</label>
									</a>
								</li>
								<li>
									<a href="#">
										<label class="checkbox-inline">
											<input type="checkbox" name="mmap_category[]" value="13"> Events
										</label>
									</a>
								</li>
								<li>
									<a href="#">
										<label class="checkbox-inline">
											<input type="checkbox" name="mmap_category[]" value="14"> Posts
										</label>
									</a>
								</li>
							</ul>
						</li>
					</ul> -->
				</div>
			</div>
		</div>
	</div>
</div>