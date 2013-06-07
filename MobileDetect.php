<?php

class MobileDetect extends Mobile_Detect {

	public static function detectDevice()
	{
		$detect = new MobileDetect();

		$mobile = $detect->isMobile();

		if ( $detect->isTablet() )
		{
			$kind = ' Tablet';
		}
		elseif ( $detect->isPhone() )
		{
			$kind = 'Phone';
		}
		else
		{	
			$kind = !$mobile ? 'Computer' : 'Phone';
		}
		
		$model = 'unavailable';
		$model = $detect->isiPhone() ? 'iPhone' : $model;
		$model = $detect->isiPad() ? 'iPad' : $model;
		$model = $detect->isBlackBerry() ? 'BlackBerry' : $model;
		$model = $detect->isHTC() ? 'HTC' : $model;
		$model = $detect->isNexus() ? 'Nexus' : $model;
		$model = $detect->isDell() ? 'Dell' : $model;
		$model = $detect->isMotorola() ? 'Motorola' : $model;
		$model = $detect->isSamsung() ? 'Samsung' : $model;
		$model = $detect->isLG() ? 'LG' : $model;
		$model = $detect->isSony() ? 'Sony' : $model;
		$model = $detect->isAsus() ? 'Asus' : $model;
		$model = $detect->isPalm() ? 'Palm' : $model;
		$model = $detect->isVertu() ? 'Vertu' : $model;
		$model = $detect->isPantech() ? 'Pantech' : $model;
		$model = $detect->isFly() ? 'Fly' : $model;
		$model = $detect->isSimValley() ? 'SimValley' : $model;
		$model = $detect->isGenericPhone() ? 'GenericPhone' : $model;
		$model = $detect->isNexusTablet() ? 'Nexus Tablet' : $model;
		$model = $detect->isSamsungTablet() ? 'Samsung Tablet' : $model;
		$model = $detect->isKindle() ? 'Kindle' : $model;
		$model = $detect->isSurfaceTablet() ? 'Surface Tablet' : $model;
		$model = $detect->isAsusTablet() ? 'Asus Tablet' : $model;
		$model = $detect->isBlackBerryTablet() ? 'BlackBerry Tablet' : $model;
		$model = $detect->isHTCtablet() ? 'HTC tablet' : $model;
		$model = $detect->isMotorolaTablet() ? 'Motorola Tablet' : $model;
		$model = $detect->isNookTablet() ? 'Nook Tablet' : $model;
		$model = $detect->isAcerTablet() ? 'Acer Tablet' : $model;
		$model = $detect->isToshibaTablet() ? 'Toshiba Tablet' : $model;
		$model = $detect->isLGTablet() ? 'LG Tablet' : $model;
		$model = $detect->isYarvikTablet() ? 'Yarvik Tablet' : $model;
		$model = $detect->isMedionTablet() ? 'Medion Tablet' : $model;
		$model = $detect->isArnovaTablet() ? 'Arnova Tablet' : $model;
		$model = $detect->isArchosTablet() ? 'Archos Tablet' : $model;
		$model = $detect->isAinolTablet() ? 'Ainol Tablet' : $model;
		$model = $detect->isSonyTablet() ? 'Sony Tablet' : $model;
		$model = $detect->isCubeTablet() ? 'Cube Tablet' : $model;
		$model = $detect->isCobyTablet() ? 'Coby Tablet' : $model;
		$model = $detect->isSMiTTablet() ? 'SMiT Tablet' : $model;
		$model = $detect->isRockChipTablet() ? 'RockChip Tablet' : $model;
		$model = $detect->isTelstraTablet() ? 'Telstra Tablet' : $model;
		$model = $detect->isFlyTablet() ? 'Fly Tablet' : $model;
		$model = $detect->isbqTablet() ? 'bq Tablet' : $model;
		$model = $detect->isHuaweiTablet() ? 'Huawei Tablet' : $model;
		$model = $detect->isNecTablet() ? 'Nec Tablet' : $model;
		$model = $detect->isPantechTablet() ? 'Pantech Tablet' : $model;
		$model = $detect->isBronchoTablet() ? 'Broncho Tablet' : $model;
		$model = $detect->isVersusTablet() ? 'Versus Tablet' : $model;
		$model = $detect->isZyncTablet() ? 'Zync Tablet' : $model;
		$model = $detect->isPositivoTablet() ? 'Positivo Tablet' : $model;
		$model = $detect->isNabiTablet() ? 'Nabi Tablet' : $model;
		$model = $detect->isPlaystationTablet() ? 'Playstation Tablet' : $model;
		$model = $detect->isGenericTablet() ? 'Generic Tablet' : $model;

		return [
					'mobile' => $mobile,
					'kind' => trim($kind),
					'model' => trim($model),
				];

	}

}
