<?php
	/**********************************
		Developer : Rahul Negi
		Date: 15 September 2016 - 15 September 2016
		Developer Url: http://insbyrah.com/2016/9/php-make-avtars-images-with-name-initials-like-google/
	**********************************/
	define('AVATAR_SET','default'); // directory where avatars are stored
	define('LETTER_INDEX', 0);  // 0: first letter; 1: second letter; -1: last letter, etc.
	define('IMAGES_FORMAT','png');   // file format of the avatars
	define('IMAGE_UNKNOWN','unknown');
	define('IMAGES_PATH','assets/images/initials-avatar/avatars');
	define('DEMO_HOME',base_url());
	define('PROJECT_CATEGORY','');
	$project_url = DEMO_HOME.PROJECT_CATEGORY;
	define('PROJECT_URL',$project_url);
	
function generate_first_letter_avtar_url($name, $size=90){
			// get picture filename (and lowercase it) from commenter name:
		if (empty($name)){  // if, for some reason, the name is empty, set file_name to default unknown image

			$file_name = IMAGE_UNKNOWN;

		} else { // name is not empty, so we can proceed

			$file_name = substr($name, LETTER_INDEX, 1); // get one letter counting from letter_index
			$file_name = strtolower($file_name); // lowercase it...

			if (extension_loaded('mbstring')){ // check if mbstring is loaded to allow multibyte string operations
				$file_name_mb = mb_substr($name, LETTER_INDEX, 1); // repeat, this time with multibyte functions
				$file_name_mb = mb_strtolower($file_name_mb); // and again...
			} else { // mbstring is not loaded - we're not going to worry about it, just use the original string
				$file_name_mb = $file_name;
			}

			// couple of exceptions:
			if ($file_name_mb == 'ą'){
				$file_name = 'a';
				$file_name_mb = 'a';
			} else if ($file_name_mb == 'ć'){
				$file_name = 'c';
				$file_name_mb = 'c';
			} else if ($file_name_mb == 'ę'){
				$file_name = 'e';
				$file_name_mb = 'e';
			} else if ($file_name_mb == 'ń'){
				$file_name = 'n';
				$file_name_mb = 'n';
			} else if ($file_name_mb == 'ó'){
				$file_name = 'o';
				$file_name_mb = 'o';
			} else if ($file_name_mb == 'ś'){
				$file_name = 's';
				$file_name_mb = 's';
			} else if ($file_name_mb == 'ż' || $file_name_mb == 'ź'){
				$file_name = 'z';
				$file_name_mb = 'z';
			}

			// create arrays with allowed character ranges:
			$allowed_numbers = range(0, 9);
			foreach ($allowed_numbers as $number){ // cast each item to string (strict param of in_array requires same type)
				$allowed_numbers[$number] = (string)$number;
			}
			$allowed_letters_latin = range('a', 'z');
			$allowed_letters_cyrillic = range('а', 'ё');
			$allowed_letters_arabic = range('آ', 'ی');
			// check if the file name meets the requirement; if it doesn't - set it to unknown
			$charset_flag = ''; // this will be used to determine whether we are using latin chars, cyrillic chars, arabic chars or numbers
			// check whther we are using latin/cyrillic/numbers and set the flag, so we can later act appropriately:
			if (in_array($file_name, $allowed_numbers, true)){
				$charset_flag = 'number';
			} else if (in_array($file_name, $allowed_letters_latin, true)){
				$charset_flag = 'latin';
			} else if (in_array($file_name, $allowed_letters_cyrillic, true)){
				$charset_flag = 'cyrillic';
			} else if (in_array($file_name, $allowed_letters_arabic, true)){
				$charset_flag = 'arabic';
			} else { // for some reason none of the charsets is appropriate
				$file_name = IMAGE_UNKNOWN; // set it to uknknown
			}

			if (!empty($charset_flag)){ // if charset_flag is not empty, i.e. flag has been set to latin, number or cyrillic...
				switch ($charset_flag){ // run through various options to determine the actual filename for the letter avatar
					case 'number':
						$file_name = 'number_' . $file_name;
						break;
					case 'latin':
						$file_name = 'latin_' . $file_name;
						break;
					case 'cyrillic':
						$temp_array = unpack('V', iconv('UTF-8', 'UCS-4LE', $file_name_mb));
						$unicode_code_point = $temp_array[1];
						$file_name = 'cyrillic_' . $unicode_code_point;
						break;
					case 'arabic':
						$temp_array = unpack('V', iconv('UTF-8', 'UCS-4LE', $file_name_mb));
						$unicode_code_point = $temp_array[1];
						$file_name = 'arabic_' . $unicode_code_point;
						break;
					default:
						$file_name = IMAGE_UNKNOWN; // set it to uknknown
						break;
				}
			}

		}

		// detect most appropriate size based on avatar size:
		if ($size <= 48) $custom_avatar_size = '48';
		else if ($size > 48 && $size <= 96) $custom_avatar_size = '96';
		else if ($size > 96 && $size <= 128) $custom_avatar_size = '128';
		else if ($size > 128 && $size <= 256) $custom_avatar_size = '256';
		else $custom_avatar_size = '512';

		// create file path - $avatar_uri variable.
		$avatar_uri =PROJECT_URL.IMAGES_PATH.'/'.AVATAR_SET.'/'.$custom_avatar_size.'/'.$file_name.'.'.IMAGES_FORMAT;

		// return the final first letter image url:
		return $avatar_uri;

	}
	
	?>