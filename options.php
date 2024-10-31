<?php

if ( $_POST['ra_update'] ) {

	if ( $_POST['ra_sites'] ) update_option( "ra_action_sites", implode( ",", $_POST['ra_sites'] ) );
	if ( $_POST['ra_exclude_terms'] ) update_option( "ra_action_exclude_terms", $_POST['ra_exclude_terms'] );

	if ( $_POST['ra_exclude_types'] ) { 
		$i = 1;
		while ( $i <= 10 ) {	
			if ( !in_array( $i, $_POST['ra_exclude_types'] ) )
				$excludes[] = $i;
			$i++;		
		}
		
		update_option( "ra_action_exclude_types", @implode( ",", $excludes ) );	
	}		
	
	echo ' <div class="updated"><p><strong>Related Ways to Take Action has been updated!</strong></p></div>';
}

$sites = explode( ",", get_option( "ra_action_sites" ) );
$excludes = explode( ",", get_option( "ra_action_exclude_types" ) );

?>
<div class="wrap">
	<h2>Related Ways to Take Action Wordpress Plugin</h2>
	<form method="post">
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Exclude actions by term</th>
				<td>
					<input style="width:650px;" type="text" name="ra_exclude_terms" value="<?php echo get_option( "ra_action_exclude_terms") ?>" />
					<br />
					Using a comma separated list of terms and phrases, you can exclude certain actions based on their titles. For example, "turtles, doves" will exclude any actions with "turtles" or "doves" in the title. Entire titles of actions can be used to exclude to any single action.
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">Actions by type</th>
				<td><table><tr>
				<td style="border: none;">
					<input <?php if ( !in_array("1", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="1" />Group Fundraiser<br />
               <input <?php if ( !in_array("2", $excludes) ) echo "checked='checked'"; ?>  type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="2">Campaign<br />
           		<input <?php if ( !in_array("3", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="3">Pledged Action<br />
               <input <?php if ( !in_array("4", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="4">Event<br />
               <input <?php if ( !in_array("5", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="5">Affinity Group<br />
            </td>
            <td style="border: none;">
               <input <?php if ( !in_array("6", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="6">Volunteer<br />
               <input <?php if ( !in_array("7", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="7">Micro-credit Loan<br />
               <input <?php if ( !in_array("8", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="8">Petition<br />
               <input <?php if ( !in_array("9", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="9">Individual Action<br />
               <input <?php if ( !in_array("10", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="10">Unknown<br />
            </td>
            <td style="border: none;">					
					<input <?php if ( !in_array("11", $excludes) ) echo "checked='checked'"; ?> type="checkbox" id="ra_exclude_types[]" name="ra_exclude_types[]" value="11">Employment<br />        
            </td></tr></table>			
				</td>			
			</tr>
			<tr valign="top">
				<th scope="row">Actions by platform</th>
				<td><table><tr>
            <td style="border: none;">
            	<input <?php if ( in_array("830666864",$sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="830666864" />
               Amazee
               <br />
               <input <?php if ( in_array("772821349",$sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="772821349" />
               BetterPlace
               <br />
               <input <?php if ( in_array("1041101928", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="1041101928" />
               BringLight
               <br />
               <input <?php if ( in_array("519819829", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="519819829" />
               CanadaHelps
               <br />
               <input <?php if ( in_array("757797673", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="757797673" />
               Care2 Petitions
               <br />
           	</td>
				<td style="border: none;">
               <input <?php if ( in_array("685918349", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="685918349" />
               Celsias
               <br />
               <input <?php if ( in_array("583316495", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="583316495" />
               Change.org
               <br />
               <input <?php if ( in_array("116435787", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="116435787" />
               Changents
               <br />
               <input <?php if ( in_array("1061711813", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="1061711813" />
               ChangingthePresent
               <br />
               <input <?php if ( in_array("496066117", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="496066117" />
               CharityFocus
               <br />
            </td>
            <td style="border: none;">
               <input <?php if ( in_array("994130381", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="994130381" />
               ChristmasFuture
               <br />
               <input <?php if ( in_array("844796856", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="844796856" />
               Delicious
               <br />
               <input <?php if ( in_array("285985636", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="285985636" />
               DemocracyinAction
               <br />
               <input <?php if ( in_array("1016384319", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="1016384319" />
               Do Something
               <br />
               <input <?php if ( in_array("908406582", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="908406582" />
               DonorsChoose.org
               <br />
            </td>
            <td style="border: none;">				
               <div class='platform_select'>
               <input <?php if ( in_array("464798105", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="464798105" />
               DreamBank
               <br />
               <input <?php if ( in_array("434467939", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="434467939" />
               Firstgiving
               <br />
               <input <?php if ( in_array("968133144", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="968133144" />
               Fundable
               <br />
               <input <?php if ( in_array("1039924068", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="1039924068" />
               GiveMeaning
               <br />
               <input <?php if ( in_array("517402238", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="517402238" />
               GlobalGiving
               <br />
            </td></tr>
				<tr><td style="border: none;">
            	<input <?php if ( in_array("919955905", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="919955905" />
               GlobalGiving UK
               <br />
               <input <?php if ( in_array("606949681", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="606949681" />
               Helpalot
               <br />
               <input <?php if ( in_array("984299787", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="984299787" />
               Idealist.org
               <br />
               <input <?php if ( in_array("599250674", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="599250674" />
               Kiva
               <br />
               <input <?php if ( in_array("19965212", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="19965212" />
               KnightPulse
               <br />
            </td>
            <td style="border: none;">
               <input <?php if ( in_array("152672700", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="152672700" />
               MicroGiving
               <br />
               <input <?php if ( in_array("809868311", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="809868311" />
               NABUUR
               <br />
               <input <?php if ( in_array("502551104", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="502551104" />
               NGO Post
               <br />
               <input <?php if ( in_array("29079428", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="29079428" />
               PincGiving
               <br />
               <input <?php if ( in_array("850833553", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="850833553" />
               PledgeBank
               <br />
            </td>
				<td style="border: none;">
               <input <?php if ( in_array("714501136", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="714501136" />
               PolicyPitch
               <br />
               <input <?php if ( in_array("270224883", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="270224883" />
               Prax
               <br />
               <input <?php if ( in_array("499168571", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="499168571" />
               Razoo Community
               <br />
               <input <?php if ( in_array("252497774", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="252497774" />
               SixDegrees
               <br />
               <input <?php if ( in_array("661916800", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="661916800" />
               TakingITGlobal
               <br />
            </td>
				<td style="border: none;">
               <input <?php if ( in_array("906305602", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="906305602" />
               ThePoint
               <br />
               <input <?php if ( in_array("357620952", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="357620952" />
               VolunteerMatch
               <br />
               <input <?php if ( in_array("828647226", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="828647226" />
               WildlifeDirect
               <br />
               <input <?php if ( in_array("353675617", $sites) ) echo "checked='checked'"; ?> id="ra_sites[]" name="ra_sites[]" type="checkbox" value="353675617" />
               Zazengo
               <br />
            </td>
				</tr></table></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="ra_update" value="Submit" />
		</p>
	</form>
</div>