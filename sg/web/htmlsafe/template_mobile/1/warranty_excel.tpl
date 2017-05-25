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
											<p class="search_inputLabel">Username</p>
											<ul class="search_kwButtonList">
												<li class="search_kwButtonList_item">
													<input type="text" class="search_input_text" name="admin_username"/>
												</li>
											</ul>
										</li>
										<li class="search_item clearfix">
											<p class="search_inputLabel">Password</p>
											<ul class="search_kwButtonList">
												<li class="search_kwButtonList_item">
													<input type="password" class="search_input_text" name="admin_password"/>
												</li>
												<li class="search_kwButtonList_item">
													<input type="submit" value="Submit">
												</li>
											</ul>
										</li>
									</ul>
									{if $ErrorMsg != ""}
										<div class="WarrantyExcelFormMsg">{$ErrorMsg}</div>
									{/if}
								</div>

							</form>
						</div>

					</section>

				</div>

			</main>
		</div>


{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}