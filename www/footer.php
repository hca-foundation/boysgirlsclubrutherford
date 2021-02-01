		<footer class="container">
			<div class="row address">
				<div class="footer-section col-sm-3 col-xs-12">
					<h4>
						<img src="<?=$root_dir?>/img/knockout-logo.png" title="<?=$org_name?>"/>
						<span class="sr-only"><?=$org_name?></span>
					</h4>
				</div>
				<div class="footer-section col-sm-4 col-xs-12">
					<div class="address-title"><?=$org_name?></div>
					<div class="street-address"><?=$org_address?></div>
					<div class="city-state"><?=$org_city_state?></div>
					<div class="phone"><a href="tel:<?=$org_phone_tel?>" tabindex="20"><span class="glyphicon glyphicon-earphone"></span> <?=$org_phone?></a></div>
				</div>
			</div>
		</footer>
		<fieldset>
			<input type="hidden" id="npcb-env" value="<?=$GLOBALS['current_domain']?>">
			<input type="hidden" id="npcb-protocol" value="<?=$GLOBALS['current_protocol']?>">
		</fieldset>

		<script src="<?=$root_dir?>/js/main.min.js"></script>
	</body>
</html>
<?php
	$db->close();
?>