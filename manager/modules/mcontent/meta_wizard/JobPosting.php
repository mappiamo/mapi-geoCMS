<?php

	class JobPosting {

		public static function FormValue() {
			return 'Job Posting';
		}

		public static function FormName() {
			return (new \ReflectionClass(__CLASS__))->getShortName();
		}

		public static function FormTitle() { ob_start(); ?>

			Job Posting.

			<?PHP
			$FTitle = ob_get_contents();
			ob_end_clean();
			return $FTitle;
		}

		public static function FormDescription() { ob_start(); ?>

			A listing that describes a job opening in a certain organization.
			<a href="https://schema.org/JobPosting" target="_blank">Check how to fill this form.</a>

			<?PHP
			$FDesc = ob_get_contents();
			ob_end_clean();
			return $FDesc;
		}

		public static function FormBody() { ob_start(); ?>

			<h2>Job Posting content generator</h2>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<td align="right" valign="middle"><label for="title"><a href="https://schema.org/title" target="_blank">Job title</a>:</label></td>
					<td valign="top"><input type="text" name="title" id="title"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="baseSalary"><a href="https://schema.org/baseSalary" target="_blank">Base Salary</a>:</label></td>
					<td valign="top"><input name="baseSalary" type="text" required id="baseSalary" size="8" maxlength="8">
						<label for="Curency">Curency:</label>
						<select name="Curency" required id="Curency">
							<option value="USD">USD</option>
							<option value="EUR" selected>EUR</option>
							<option value="GBP">GBP</option>
						</select>

					</td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="educationRequirements"><a href="https://schema.org/educationRequirements" target="_blank">Education Requirements</a>: </label></td>
					<td valign="top"><textarea name="educationRequirements" required id="educationRequirements"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="employmentType"><a href="https://schema.org/employmentType" target="_blank">Employment Type</a>:</label></td>
					<td valign="top"><select name="employmentType" required id="employmentType">
							<option value="Full time" selected>Full time</option>
							<option value="Part time">Part time</option>
							<option value="Contract">Contract</option>
							<option value="Internship">Internship</option>
						</select></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="experienceRequirements"><a href="https://schema.org/experienceRequirements" target="_blank">Experience Requirements</a>:</label></td>
					<td valign="top"><textarea name="experienceRequirements" required id="experienceRequirements"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="hiringOrganization"><a href="https://schema.org/hiringOrganization" target="_blank">Hiring Organization</a>:</label></td>
					<td valign="top"><input name="hiringOrganization" type="text" required id="hiringOrganization"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="incentiveCompensation"><a href="https://schema.org/incentiveCompensation" target="_blank">Incentive Compensation</a>:</label></td>
					<td valign="top"><textarea name="incentiveCompensation" required id="incentiveCompensation"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="industry"><a href="https://schema.org/industry" target="_blank">Industry</a>:</label></td>
					<td valign="top"><input name="industry" type="text" required id="industry" maxlength="100"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="jobBenefits"><a href="https://schema.org/jobBenefits" target="_blank">Job Benefits</a>:</label></td>
					<td valign="top"><textarea name="jobBenefits" required id="jobBenefits"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="occupationalCategory"><a href="https://schema.org/occupationalCategory" target="_blank">Occupational Category</a>:</label></td>
					<td valign="top"><input name="occupationalCategory" type="text" required id="occupationalCategory" maxlength="100"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="qualifications"><a href="https://schema.org/qualifications" target="_blank">Qualifications</a>:</label></td>
					<td valign="top"><textarea name="qualifications" required id="qualifications"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="responsibilities"><a href="https://schema.org/responsibilities" target="_blank">Responsibilities</a>:</label></td>
					<td valign="top"><textarea name="responsibilities" required id="responsibilities"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="salaryCurrency"><a href="https://schema.org/salaryCurrency" target="_blank">Salary Currency</a>:</label></td>
					<td valign="top"><select name="salaryCurrency" required id="salaryCurrency">
							<option value="USD">USD</option>
							<option value="EUR" selected>EUR</option>
							<option value="GBP">GBP</option>
						</select></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="skills"><a href="https://schema.org/skills" target="_blank">Skills</a>:</label></td>
					<td valign="top"><textarea name="skills" required id="skills"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="specialCommitments"><a href="https://schema.org/specialCommitments" target="_blank">Special Commitments</a>:</label></td>
					<td valign="top"><textarea name="specialCommitments" id="specialCommitments"></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="workHours"><a href="https://schema.org/workHours" target="_blank">Work Hours</a>:</label></td>
					<td valign="top"><input name="workHours" type="text" required id="workHours"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="telephone2"><a href="https://schema.org/telephone" target="_blank">Telephone</a>:</label></td>
					<td valign="top"><input name="telephone" type="text" id="telephone"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="email2"><a href="https://schema.org/email" target="_blank">Email</a>:</label></td>
					<td valign="top"><input name="email" type="text" id="email"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="faxNumber2"><a href="https://schema.org/faxNumber" target="_blank">Fax Number</a>:</label></td>
					<td valign="top"><input name="faxNumber" type="text" id="faxNumber"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="founder3"><a href="https://schema.org/founder" target="_blank">Founder</a>:</label></td>
					<td valign="top"><input name="founder" type="text" id="founder"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="owns3"><a href="https://schema.org/owns" target="_blank">Owns</a>:</label></td>
					<td valign="top"><input name="owns" type="text" id="owns"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="taxID3"><a href="https://schema.org/taxID" target="_blank">Tax ID</a>:</label></td>
					<td valign="top"><input name="taxID" type="text" id="taxID"></td>
				</tr>
				<tr>
					<td align="right" valign="middle"><label for="vatID3"><a href="https://schema.org/vatID" target="_blank">Vat ID</a>:</label></td>
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