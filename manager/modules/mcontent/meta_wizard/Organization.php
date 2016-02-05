<?php

	class Organization {

	 	public static function FormValue() {
			return 'Organization.';
		}

		public static function FormName() {
			return (new \ReflectionClass(__CLASS__))->getShortName();
		}

		public static function FormTitle() { ob_start(); ?>

			Organization.

			<?PHP
			$FTitle = ob_get_contents();
			ob_end_clean();
			return $FTitle;
		}

		public static function FormDescription() { ob_start(); ?>

			An organization such as a school, NGO, corporation, club, etc.
			<a href="https://schema.org/Organization" target="_blank">Check how to fill this form.</a>

			<?PHP
			$FDesc = ob_get_contents();
			ob_end_clean();
			return $FDesc;
		}

		public static function FormBody() { ob_start(); ?>

			<h3>Organization content generator.</h3>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td align="right" valign="middle"><label for="aggregateRating"><a href="https://schema.org/aggregateRating">Aggregate Rating</a>:</label></td>
					<td><input type="text" name="aggregateRating" id="aggregateRating"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="alumni2"><a href="https://schema.org/alumni">Alumni</a>:</label></td>
					<td><input type="text" name="alumni" id="alumni"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="brand2"><a href="https://schema.org/brand">Brand</a>:</label></td>
					<td><input type="text" name="brand" id="brand"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="contactPoint2"><a href="https://schema.org/contactPoint">Contact Point</a>:</label></td>
					<td><input type="text" name="contactPoint" id="contactPoint"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="department2"><a href="https://schema.org/department">Department</a>:</label></td>
					<td><input type="text" name="textfield5" id="textfield5"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="textfield2"><a href="https://schema.org/dissolutionDate">Dissolution Date</a>:</label></td>
					<td><input type="text" name="department" id="department"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="duns2"><a href="https://schema.org/duns">Duns</a>:</label></td>
					<td><input type="text" name="duns" id="duns"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="email2"><a href="https://schema.org/email">Email</a>:</label></td>
					<td><input type="text" name="email" id="email"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="employee2"><a href="https://schema.org/employee">Employee</a>:</label></td>
					<td><input type="text" name="employee" id="employee"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="faxNumber2"><a href="https://schema.org/faxNumber">Fax Number</a>:</label></td>
					<td><input type="text" name="faxNumber" id="faxNumber"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="founder2"><a href="https://schema.org/founder">Founder</a>:</label></td>
					<td><input type="text" name="founder" id="founder"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="foundingDate2"><a href="https://schema.org/foundingDate">Founding Date</a>:</label></td>
					<td><input type="text" name="foundingDate" id="foundingDate"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="hasOfferCatalog2"><a href="https://schema.org/hasOfferCatalog">Has Offer Catalog</a>:</label></td>
					<td><input type="text" name="hasOfferCatalog" id="hasOfferCatalog"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="isicV2"><a href="https://schema.org/isicV4">isicV4</a>:</label></td>
					<td><input type="text" name="isicV4" id="isicV4"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="legalName2"><a href="https://schema.org/legalName">Legal Name</a>:</label></td>
					<td><input type="text" name="legalName" id="legalName"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="member2"><a href="https://schema.org/member">Member</a>:</label></td>
					<td><input type="text" name="member" id="member"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="memberOf2"><a href="https://schema.org/memberOf">Member Of</a>:</label></td>
					<td><input type="text" name="memberOf" id="memberOf"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="naics2"><a href="https://schema.org/naics">Naics</a>:</label></td>
					<td><input type="text" name="naics" id="naics"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="numberOfEmployees2"><a href="https://schema.org/numberOfEmployees">Number Of Employees</a>:</label></td>
					<td><input type="text" name="numberOfEmployees" id="numberOfEmployees"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="owns2"><a href="https://schema.org/owns">Owns</a>:</label></td>
					<td><input type="text" name="owns" id="owns"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="parentOrganization2"><a href="https://schema.org/parentOrganization">Parent Organization</a>:</label></td>
					<td><input type="text" name="parentOrganization" id="parentOrganization"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="seeks2"><a href="https://schema.org/seeks">Seeks</a>:</label></td>
					<td><input type="text" name="seeks" id="seeks"></td>
				</tr>
				</tbody>
			</table>

		<?PHP
			$FormSourceData = ob_get_contents();
			ob_end_clean();
			return $FormSourceData;
		}
	}


