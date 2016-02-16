<?php

	class MotorcycleDealer {

	 	public static function FormValue() {
			return 'A motorcycle dealer.';
		}

		public static function FormName() {
			return (new \ReflectionClass(__CLASS__))->getShortName();
		}

		public static function FormTitle() { ob_start(); ?>

			A motorcycle dealer.

			<?PHP
			$FTitle = ob_get_contents();
			ob_end_clean();
			return $FTitle;
		}

		public static function FormDescription() { ob_start(); ?>

			<a href="https://schema.org/MotorcycleDealer" target="_blank">Check how to fill this form.</a>

			<?PHP
			$FDesc = ob_get_contents();
			ob_end_clean();
			return $FDesc;
		}

		public static function FormBody() { ob_start(); ?>

			<h3>A motorcycle dealer content generator.</h3>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td align="right" valign="middle"><label for="branchCode"><a href="https://schema.org/branchCode" target="_blank">Branch Code</a>:</label></td>
					<td valign="top"><input name="branchCode" type="text" id="branchCode" maxlength="100"></td>
				</tr>
				<tr align="right" valign="middle">
					<td colspan="2" align="left">A   short textual code (also called "store code") that uniquely identifies a   place of business. The code is typically assigned by the   parentOrganization and used in structured URLs.
						For example, in the URL   http://www.starbucks.co.uk/store-locator/etc/detail/3047 the code "3047"   is a branchCode for a particular branch. </td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="currenciesAccepted"><a href="https://schema.org/currenciesAccepted" target="_blank">Currencies Accepted</a>:</label></td>
					<td valign="top">				<input type="checkbox" name="currenciesAccepted" value="USD" id="currenciesAccepted_0"><label>USD</label>
						<br>
						<input type="checkbox" name="currenciesAccepted" value="EUR" id="currenciesAccepted_1"><label>EUR</label>
						<br>
						<input type="checkbox" name="currenciesAccepted" value="GBP" id="currenciesAccepted_2"><label>GBP</label></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="openingHours"><a href="https://schema.org/openingHours" target="_blank">Opening Hours</a>:</label></td>
					<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
								<td align="center">&nbsp;</td>
								<td align="center">From:</td>
								<td align="center">to:</td>
							</tr>
							<tr>
								<td align="right">Monday</td>
								<td><input name="opening_mo_from" type="text" required id="opening_mo_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_mo_to" type="text" required id="opening_mo_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Tuesday</td>
								<td><input name="opening_tu_from" type="text" required id="opening_tu_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_tu_to" type="text" required id="opening_tu_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Wednesday</td>
								<td><input name="opening_we_from" type="text" required id="opening_we_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_we_to" type="text" required id="opening_we_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Thuesday</td>
								<td><input name="opening_th_from" type="text" required id="opening_th_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_th_to" type="text" required id="opening_th_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Friday</td>
								<td><input name="opening_fr_from" type="text" required id="opening_fr_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_fr_to" type="text" required id="opening_fr_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Saturday</td>
								<td><input name="opening_sa_from" type="text" required id="opening_sa_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_sa_to" type="text" required id="opening_sa_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							<tr>
								<td align="right">Sunday</td>
								<td><input name="opening_su_from" type="text" required id="opening_su_from" size="5" maxlength="5" class="small_textinput"></td>
								<td><input name="opening_su_to" type="text" required id="opening_su_to" size="5" maxlength="5" class="small_textinput"></td>
							</tr>
							</tbody>
						</table></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="paymentAccepted"><a href="https://schema.org/paymentAccepted" target="_blank">Payment Accepted</a>:</label></td>
					<td valign="top"><input type="checkbox" name="paymentAccepted" value="Cash" id="paymentAccepted_0">
						<label>Cash</label>
						<br>
						<input type="checkbox" name="paymentAccepted" value="Credit Card" id="paymentAccepted_1">
						<label>Credit Card</label>
						<br>
						<input type="checkbox" name="paymentAccepted" value="Wire transfer" id="paymentAccepted_2">
						<label>Wire transfer</label>
						<br>
						<input type="checkbox" name="paymentAccepted" value="Paypal" id="paymentAccepted_3">
						<label>Paypal</label></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="priceRange"><a href="https://schema.org/priceRange" target="_blank">Price Range</a>:</label></td>
					<td valign="top"><input name="priceRange" type="text" id="priceRange"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="telephone"><a href="https://schema.org/telephone" target="_blank">Telephone</a>:</label></td>
					<td valign="top"><input name="telephone" type="text" id="telephone"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="email"><a href="https://schema.org/email" target="_blank">Email</a>:</label></td>
					<td valign="top"><input name="email" type="text" id="email"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="faxNumber"><a href="https://schema.org/faxNumber" target="_blank">Fax Number</a>:</label></td>
					<td valign="top"><input name="faxNumber" type="text" id="faxNumber"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="founder2"><a href="https://schema.org/founder" target="_blank">Founder</a>:</label></td>
					<td valign="top"><input name="founder" type="text" id="founder"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="owns2"><a href="https://schema.org/owns" target="_blank">Owns</a>:</label></td>
					<td valign="top"><input name="owns" type="text" id="owns"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="taxID2"><a href="https://schema.org/taxID" target="_blank">Tax ID</a>:</label></td>
					<td valign="top"><input name="taxID" type="text" id="taxID"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="vatID2"><a href="https://schema.org/vatID" target="_blank">Vat ID</a>:</label></td>
					<td valign="top"><input name="vatID" type="text" id="vatID"></td>
				</tr>
				</tbody>
			</table>

		<?PHP
			$FormSourceData = ob_get_contents();
			ob_end_clean();
			return $FormSourceData;
		}
	}


