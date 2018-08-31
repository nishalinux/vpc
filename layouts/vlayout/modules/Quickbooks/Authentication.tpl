					<div>
						<div>
						<!--	</br></br>
						<p>
							When you post, <strong>make sure that you:</strong>
						</p>
						<ul>
							<li>Post your code.</li>
							<li>Check that all of your OAuth credentials and URLs match between your code and your Intuit account.</li>
							<li>Post your XML request/response. <a href="quickbooks/debugging.php">Don't know how to get the request/response?</a></li>
							<li>Post the results of the <a href="quickbooks/troubleshooting.php">troubleshooting script</a>.</li>
						</ul>-->

						<p>
							QuickBooks connection status:

				 
				 {* {php}
							var_dump($quickbooks_is_connected);
				 {/php} *}

				
						{if $quickbooks_is_connected}
							<div style="border: 2px solid green; text-align: center; padding: 8px; color: green;">
								CONNECTED!<br>
							<br>
							<i>
								Realm: {$realm}<br>
								Company: {$quickbooks_CompanyInfo->getCompanyName()}<br>
								Email: {$quickbooks_CompanyInfo->getEmail()->getAddress()}<br>
								Country: {$quickbooks_CompanyInfo->getCountry()}
							</i>
							</div>

							<h2>QuickBooks Stuff</h2>

					<table class="quickbooks">
						 
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="quickbooks/disconnect.php"><button>Disconnect from QuickBooks</button></a>
							</td>
							<td>
								(If you do this, you'll have to go back through the authorization/connection process to get connected again)
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="quickbooks/reconnect.php"><button>Reconnect / refresh connection</button></a>
							</td>
							<td>
								(QuickBooks connections expire after 6 months, so you have to this roughly every 5 and 1/2 months)
							</td>
						</tr>
						<!--<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="quickbooks/diagnostics.php"><button>Diagnostics about QuickBooks connection</button></a>
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<a href="quickbooks/debugging.php"><button>Need help debugging/troubleshooting?</button></a>
							</td>
							<td>
								&nbsp;
							</td>
						</tr>-->
					</table>

				{else}
					<div style="border: 2px solid red; text-align: center; padding: 8px; color: red;">
						<b>NOT</b> CONNECTED!<br>
						<br>
						<ipp:connectToIntuit></ipp:connectToIntuit>
						<br>
						<br>
						You must authenticate to QuickBooks <b>once</b> before you can exchange data with it. <br>
						<br>
						<strong>You only have to do this once!</strong> <br><br>

						After you've authenticated once, you never have to go
						through this connection process again. <br>
						Click the button above to
						authenticate and connect.
					</div>
				{/if}

					</p>
					</div> 
				</div>