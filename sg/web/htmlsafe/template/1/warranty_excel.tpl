{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

		<div class="main">
			<main>

				<div class="headingLv1Block noBorder">
					<h1 class="headingLv1">Warranty Excel</h1>
				</div>

				<div class="container">

					<section>

						<div class="search SearchPage">
							<form id="WarrantyExcelForm" action="{$BASEURL}/warranty_excel.php" method="POST">
								<div class="clearfix">
									<ul class="search_itemList">
										<li class="search_item clearfix">

											<div class="WarrantyExcelLogin">
												<div>
													<p>Username:</p>
													<input type="text" name="admin_username"/>
												</div>

												<div>
													<p>Password:</p>
													<input type="password" name="admin_password"/>
												</div>

												<input type="submit" value="Submit">
											</div>
											
											{if $ErrorMsg != ""}
												<div class="WarrantyExcelFormMsg">{$ErrorMsg}</div>
											{/if}

										</li>
										
									</ul>
								</div>
							</form>
						</div>

					</section>

				</div>

			</main>
		</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}