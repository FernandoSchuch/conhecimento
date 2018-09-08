<?php
if(! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

/**
 * Helpers
 *
 * Ferramentas uteis
 *
 * @author		Anderson N. Isotton
 * @version		1.0.0
 */
if(! function_exists ( 'andSQL' )){
	function andSQL($sql) {
		if (trim($sql) == '')
			return $sql;
		else
			return ' AND ' . $sql;
	}
}

//Converte um registro retornado do banco em campos separados por ## para enviar para o JQuery fazer uma split 
//Utilizada para buscar e sugerir registros nas telas
if(! function_exists ( 'arrayToSplit' )){
	function arrayToSplit($dados) {
		$result = '';
		if ( count($dados) > 0 ):
			foreach ($dados as $Key => $valor):
				$result .= ($result == '') ? $valor : '##' . $valor;
			endforeach;
		endif;
		
		return $result;
	}
}

//Move um item do array para outra posicao informada
if(! function_exists ( 'array_reorder' )){
	function array_reorder($array, $oldIndex, $newIndex) {
		array_splice($array, $newIndex,	count($array),
					array_merge(array_splice($array, $oldIndex, 1),
								array_slice($array, $newIndex, count($array))
								)
					);
		
		return $array;
	}
}

if(! function_exists ( 'acentuar' )){
	function acentuar($termo) {
		$termo = str_replace('calculo', 		'c�lculo', 			$termo);
		$termo = str_replace('classificacao',	'classifica��o',	$termo);
		$termo = str_replace('codigo', 			'c�digo', 			$termo);
		$termo = str_replace('combinacao', 		'combina��o', 		$termo);
		$termo = str_replace('comercio',		'com�rcio', 		$termo);
		$termo = str_replace('condicao',		'condi��o', 		$termo);
		$termo = str_replace('condicoes_venda',	'condi��es venda',  $termo);
		$termo = str_replace('consignatario',	'consignat�rio', 	$termo);
		$termo = str_replace('descricao', 		'descri��o', 		$termo);
		$termo = str_replace('inicio', 			'in�cio', 			$termo);
		$termo = str_replace('inscricao', 		'inscri��o', 		$termo);
		$termo = str_replace('minima', 			'm�nima', 			$termo);
		$termo = str_replace('numero', 			'n�mero', 			$termo);
		$termo = str_replace('observacao', 		'observa��o', 		$termo);
		$termo = str_replace('preco', 			'pre�o', 			$termo);
		$termo = str_replace('producao', 		'produ��o', 		$termo);
		$termo = str_replace('propria', 		'pr�pria', 			$termo);
		$termo = str_replace('razao', 			'raz�o', 			$termo);
		$termo = str_replace('referencia', 		'refer�ncia', 		$termo);		
		
		return $termo;
	}
}

if(! function_exists ( 'campoFormatado' )){
	function campoFormatado( $campo ){
		$campo = strtolower($campo);
		return 	contem('cnpj', $campo) or 
				contem('inscricao_estadual', $campo) or
				contem('telefone', $campo) or
				contem('cep', $campo);
	}
}

if(! function_exists ( 'coalesce' )){
	function coalesce($array1, $array2 ) {
		return ($array1) ? $array1 : $array2;
	}
}
		
if(! function_exists ( 'comparaFloat' )){
	function comparaFloat($valor1, $valor2, $decimais) {
		$r1 = formataFloat ( $valor1, $decimais );
		$r2 = formataFloat ( $valor2, $decimais );
		$result = $r1 == $r2;
		
		return $result; 
	}
}

if(! function_exists ( 'codificacao' )){
	function codificacao($string) {
		return mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	}
}

if(! function_exists ( 'format' )){
	function format ( $texto, $values ) {
		if ( is_array($values) ):
			foreach ( $values as $valor ):
				$onde  = strpos($texto, '%s');
				$texto = substr_replace($texto, $valor, $onde, 2);
			endforeach;
		else: 
			//Se passar duas strings, substitui todas as ocorrências
			$texto = str_replace('%s', $values, $texto); 
		endif;
		
		return $texto;
	}
}

if(! function_exists ( 'formataCep' )){
	function formataCep($cep) {
		return $result = formatMaskText(CMSKCEP, $cep);
	}
}

if(! function_exists ( 'contem' )){
	function contem($substr, $str) {
		$result = strpos($str, $substr);
		if ( is_numeric($result) ):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
}
if(! function_exists ( 'converteData' )){
	function converteData($data, $hora = true) {
		if ($data == ''):
			$saida = '';
		else:
			$datatime = explode ( ' ', $data );
		
			if(count ( $datatime ) > 1):
				$data = $datatime [0];
				$time = explode ( '.', $datatime [1] );
				$time = $time [0];
			endif;
			
			if(strstr ( $data, '-' )):
				@$data = explode ( '-', $data );
				@$saida = $data [2] . '/' . $data [1] . '/' . $data [0];
			else:
				@$data = explode ( '/', $data );
				@$saida = $data [2] . '-' . $data [1] . '-' . $data [0];
			endif;
		
			if(@$time && $hora):
				$saida .= ' ' . $time;
	    	endif;
	    endif;
	    
		return $saida;
	}
}

if(! function_exists ( 'DaysBetween' )){
	function DaysBetween ( $dataInicial, $dataFinal ){
		//Usa a fun��o strtotime() e pega o timestamp das duas datas. Tem que passar dois Dates e n�o String:
		
		$timeInicial = strtotime(stringToData(converteData( $dataInicial )));
		$timeFinal   = strtotime(stringToData(converteData( $dataFinal )));
		
		//Calcula a diferen�a de segundos entre as duas datas:
		$diferenca = $timeFinal - $timeInicial; //em segundos
		
		$dias = (int)floor( $diferenca / (60 * 60 * 24)); //Calcula a diferen�a de dias
		
		Return $dias;
	}
}

if(! function_exists ( 'DuplicouPK' )){
	function DuplicouPK($mensagem){
		Return 	contem('value violates unique constraint', $mensagem) ||
				contem('viola a restrição de unicidade', $mensagem);
	}
}

if(! function_exists ( 'arrayIsEmpty' )){
	function arrayIsEmpty($arr, $strExcetoKeys){
		$result = true;
		foreach ($arr as $key => $valor):
			//Pode passar alguns campos que n�o devem ser considerados como valores informados.
			if ( ($valor != '') and ( !contem($key, $strExcetoKeys) ))
				$result = false;
		endforeach;
		return $result;
	}
}

if(! function_exists ( 'formataFone' )){
	function formataFone($fone) {
		if(substr($fone,0,1) == '0'):
			$ddd = substr($fone,0,3);
			if(strlen(substr($fone,3,strlen($fone))) == 10):
				$fone = substr($fone,3,6).'-'.substr($fone,8,strlen($fone));
			else:
				$fone = substr($fone,3,5).'-'.substr($fone,7,strlen($fone));			
			endif;
		else:
			$ddd = substr($fone,0,2);
			if(strlen(substr($fone,2,strlen($fone))) == 10):
				$fone = substr($fone,2,6).'-'.substr($fone,8,strlen($fone));
			else:
				$fone = substr($fone,2,5).'-'.substr($fone,7,strlen($fone));
			endif;
		endif;
		$foneformat = '('.$ddd.') '.$fone;
		return $foneformat;
	}
}

if(! function_exists ( 'formataCnpj' )){
	function formataCnpj($cnpj) {
		$cnpj = limpaCaracteres($cnpj);
		if ( trim($cnpj) == ''):
			return '';
		elseif (strlen($cnpj) <= 11):
			return $result = formatMaskText(CMSKCPF, $cnpj);
		else:
			return $result = formatMaskText(CMSKCNPJ, $cnpj);
		endif;
	}
}

//Percorre o array limpando o elemento do primeiro array, se a Key dele for igual ao campo do segundo
if(! function_exists ( 'retiraCamposExtras' )){
	function retiraCamposExtras(&$origem, $camposExtras){
		foreach ($camposExtras as $key => $campo):
			if ( isset($origem[$campo]) ):
				unset($origem[$campo]);
			endif;
		endforeach;
	}
}

if(! function_exists ( 'limpaCaracteres' )){
	function limpaCaracteres($valor){
		return preg_replace("/[^a-zA-Z0-9\s]/", "", $valor);
	}
}

if(! function_exists ( 'formataFloat' )){
	function formataFloat($valor, $decimais = 2) {
    	if(is_numeric($valor)):
    		return number_format($valor, $decimais, ',', '.'); 
    	else:
			$auxval = (float) str_replace(',', '.', str_replace('.', '', $valor));
    		return formataFloat($auxval, $decimais, ',', '.');
    	endif; 
	}
}

if(! function_exists ( 'stringToFloat' )){ 
	function stringToFloat($valor, $decimais = 2) {
		if ( is_numeric($valor) ):
    		return number_format($valor, $decimais, '.', '');
		else:
			$auxval = (float) str_replace(',', '.', str_replace('.', '', $valor));
			return stringToFloat($auxval, $decimais);
		endif;
	}
}

if(! function_exists ( 'stringToInteger' )){ 
	function stringToInteger($valor) {
		if ( is_numeric($valor) ):
    		return (int)$valor;
		else:
			return 0;
		endif;
	}
}

if(! function_exists ( 'getClassValor' )){
	function getClassValor($decimais, $readOnly, $subClass = '') {
		if ( $decimais > 0 )
			$result = 'valor' . $decimais;
		else 
			$result = 'inteiro';
		
		$result = 'Class="' . $result . ' ' . (($subClass=='') ? '' : $subClass) . '" ' . (( $readOnly )? 'readonly ': '');
		
		return $result;
	}
}

//
if(! function_exists ( 'getWhereSQL' )){
	function getWhereSQL($campo, $operador, $conteudo, $tipoCampo) {
		//Tratamento para SQL Injection
		if ($conteudo != ''):
			if ( $tipoCampo == TCNUMERO ):
				if ( $operador == 'ILIKE' ):
					$operador = '=';
				endif;
				if ( !is_numeric($conteudo) ):
					$conteudo = 0;
				endif;
			
			elseif ( ($tipoCampo == TCDATA) or ($tipoCampo == TCDATAHORA) ):
				if ( $operador == 'ILIKE' ):
					$operador = '=';
				endif;
				$conteudo = "'{$conteudo}'";
				
			else: //TCCARACTER
				
				$campo = "fc_ascii({$campo})";
				$conteudo = utf8_decode( $conteudo ); //Como foi desenvolvido em ISO, tem que usar utf8_decode
			
				if ($operador == 'ILIKE'):
					$conteudo = "fc_ascii('" . getLike($conteudo) . "')"; 
				else:
					$conteudo = "'{$conteudo}'";
				endif;
				
			endif;
			
			return $campo . ' ' . $operador . ' ' . $conteudo;
			 
		else:
			return '';
		endif;
	}
}

if(! function_exists ( 'getHtmlGradeItemPedido' )){
	function getHtmlGradeItemPedido( $grade, $decimais, $permiteEditar ){

		$tamanhosGrade = '<thead><tr><th width="10%" style="text-align:left">Tamanho</th>';
		$valoresGrade  = '<tbody><tr><td>Quantidade</td>';
		$conta         = 1;
		
		if ( !empty($grade) ):
			$pWidth = floor( 100 / (count($grade) + 1) );
			foreach ( $grade as $tamanho ):
				$tamanhosGrade .= getInputGipTamanho( $conta, $tamanho['tam_tamanho'], $pWidth ) . SKIP;
				$valoresGrade  .= getInputGipQuantidade( $conta, $tamanho['gip_quantidade'], $decimais, (!$permiteEditar)) . SKIP;
				$conta++;
			endforeach;
		endif;

		$tamanhosGrade .= '</tr></thead>';
		$valoresGrade  .= '</tr></tbody>';

		return $tamanhosGrade . $valoresGrade;
	}
}

/*
 * Procura o arquivo no diret�io e retorna somente o nome porque no html, tem que gerar com http://
 */
if(! function_exists ( 'getImagem' )){
	function getImagem ($pasta, $nomeArquivo) {
		$nomeArquivo = $pasta . strtolower($nomeArquivo);
		$result      = $nomeArquivo . '.jpg';
		if ( !file_exists( $result ) ):
			$result = $nomeArquivo . '.bmp';
			if ( !file_exists( $result ) ):
				$result = $nomeArquivo . '.png';
				if ( !file_exists( $result ) )
					$result = $pasta . 'no_image.png';
			endif;
		endif;
			
		return basename($result);
	}
}

if(! function_exists ( 'getInputGipQuantidade' )){
	function getInputGipQuantidade($posicaoGrade, $quantidade, $decimais, $readOnly) {
		$result  = '<td><input type="tel" name="tam_quantidade'.$posicaoGrade.'" ';
		$result .= getClassValor($decimais, $readOnly, 'span12 required');  
		$result .= 'value="' . formataFloat($quantidade, $decimais) .'"></td>';
		return $result; 
	}
}

if(! function_exists ( 'getInputGipTamanho' )){
	function getInputGipTamanho($posicaoGrade, $tamanho, $pWidth) {
		$result  = '<th class="Data" width="'.$pWidth.'%"><input type="hidden" name="tam_tamanho'.$posicaoGrade;
		$result .= '" value="' . $tamanho .'">' . $tamanho . '</th>'; 
		return $result;
	}
}

if(! function_exists ( 'getInputGipQuantidadeVertical' )){
	function getInputGipQuantidadeVertical($posicaoGrade, $quantidade, $decimais, $readOnly) {
		$result  = '<td><input type="tel" name="tam_quantidade'.$posicaoGrade.'" style="float:right" ';
		$result .= getClassValor($decimais, $readOnly, 'span8 required');  
		$result .= 'value="' . formataFloat($quantidade, $decimais) .'"></td>';
		return $result; 
	}
}

if(! function_exists ( 'getInputGipTamanhoVertical' )){
	function getInputGipTamanhoVertical($posicaoGrade, $tamanho, $somenteNumeros, $readOnly, $maxLength) {
		$result  = '<td><input type="text" name="tam_tamanho'.$posicaoGrade.'" style="float:right" '; 
		$result .= 'class="' .(($somenteNumeros)? 'inteiro ' : '') . 'span8 tam_tamanho required" value="' . $tamanho .'" ';
		$result .= (($readOnly)? 'readonly ' : '') . 'maxlength="' . $maxLength .'"></td>';
		return $result;
	}
}

if(! function_exists ( 'getLike' )){
	function getLike($filtro) {
		if ($filtro == '')
			return '';
		else //Tratamento para SQL Injection
			return '%' . str_replace( "'", "''", str_replace( ' ', '%', $filtro )) . '%';
	}
}

if(! function_exists ( 'limitar' )){
	function limitar($string, $tamanho = 50, $encode = 'iso-8859-1') { //UTF-8
		if ( strlen ( $string ) > $tamanho ):
			$string = mb_substr ( $string, 0, $tamanho - 3, $encode ) . '...';
		else:
			$string = mb_substr ( $string, 0, $tamanho, $encode );
		endif;
		
		return $string;
	}
}

if(! function_exists ( 'lPad' )){
	function lPad($texto, $tamanho, $caracter = ' ') {
		return str_pad($texto, $tamanho, $caracter, STR_PAD_LEFT); 
	}
}

/*
 * Transforma o field na chave do array depois ordena pela chave e recria o array ordenado
 */
if(! function_exists ( 'ordenaArray' )){
	function ordenaArray($dados, $field, $inverse = false) {
		
		$position = array ();
		$newArray = array ();
		$i = 0;
		foreach($dados as $key => $row):
			$i++;
			$p = $row[$field]; //Aqui poderia ser v�rios campos
			if ( isset($position[$p]) )
				$position[$p.lPad($i, 10, '0')] = $key;
			else
				$position[$p] = $key;
		endforeach;
		
		if ($inverse)
			krsort ( $position, SORT_STRING);
		else
			rsort ( $position, SORT_NATURAL );
		
		foreach ($position as $key=>$p):
			$newArray[] = $dados[$p]; 
		endforeach;
		 
		return $newArray;
	}
}

// Esta function deve ser utilizada apenas na obra para reordenar os itens
if(! function_exists ( 'orderMultiDimensionalArray' )){
	function orderMultiDimensionalArray($toOrderArray, $field, $inverse = false) {
		
		$position = array ();
		$newRow = array ();
		foreach($toOrderArray as $key => $row){
			$position [$key] = $row [$field];
			$newRow [$key] = $row;
		}
		if($inverse){
			arsort ( $position );
		}else{
			asort ( $position );
		}
		$returnArray = array ();
		foreach($position as $key => $pos){
			$returnArray [] = $newRow [$key];
		}
		return $returnArray;
	}
}

if(! function_exists ( 'percentual' )){
	function percentual($valor, $base, $decimais) {
		if($base > 0):
			$result = round($valor / $base * 100, $decimais);
		else:
			$result = 0;
		endif;
		return $result;
	}
}

if(! function_exists ( 'posDelphi' )){
	function posDelphi($substr, $str) {
		return strpos($str, $substr);
	}
}		

/*
 * Recebe os dados do formul�rio e converte conforme seu tipo para gravar no banco de dados
 * Antes tem que tirar todos os campos que n�o fazem parte da tabela que o array representa (Quando estiver limpando para colocar na session, pode deixar outros campos)
 * Em $tipos[$key] tem que vir o nome do campo, o tipo dele conforme as constantes definidas no constantes.php (TC...) e a quantidade de decimais no Postgres
 */
if(! function_exists ( 'preparaArray' )){
	function preparaArray(&$dados, $tipos, $debug = false) {
		//Passagem de par�metro por refer�ncia, por isso n�o retorna nada
		if ($dados)
		foreach($dados as $key => $valor):
		
			if (is_numeric($valor)) //0 � considerado null
				$valorNulo = (trim($valor) == '') or empty($valor);
			else
				$valorNulo = (!$valor) or ($valor == '') or empty($valor);
		
			if ( campoFormatado( $key ) ):
				if ( $debug ):
					echo '[ FORMATAD ]'.rPad($key, 30).' = '.$valor;
				endif;
				
				$valor = ($valorNulo) ? null : limpaCaracteres( $valor );
			
				if ( $debug ):
					echo ' => '.$valor.SKIP;
				endif;
			
			elseif ( isset($tipos[$key]) ): //$key tem o nome do campo
				
				if ( $debug ):
					echo '[ '.rPad($tipos[$key]['tipo'], 8).' ]'.rPad($key, 30).' = '.$valor;
				endif;
				
				if ( $tipos[$key]['tipo'] == TCDATA ):
					$valor = ($valorNulo) ? null : stringToData( $valor );
				
				elseif ( $tipos[$key]['tipo'] == TCDATAHORA ):
					$valor = ($valorNulo) ? null : converteData( $valor, true);
				
				elseif ( $tipos[$key]['tipo'] == TCNUMERO ):
					$valor = ($valorNulo) ? null : stringToFloat( $valor, $tipos[$key]['decimais'] );
				
				elseif ( !contem('mail', $key) ):
					$valor = ($valorNulo) ? null : strtoupper( utf8_decode( $valor ));
					
				endif;
				
				if ( $debug ):
					echo ' => '.$valor.SKIP;
				endif;
			else:
				if ( $debug ):
					echo rPad('', 12).rPad($key, 30).' * '.$valor.''.SKIP;
				endif;
			endif;
			
			$dados[$key] = $valor;
		endforeach;
	}
}

if(! function_exists ( 'preparaArrayInsert' )){
	function preparaArrayInsert($dados) {
		$returnArray = array ();
		foreach($dados as $key => $value){
			if ( is_string($value) ):
				if (! empty($value)):
					$returnArray [$key] = strtoupper( $value );
				endif;
			else:
				if($value)
					$returnArray [$key] = $value;
				else 
					unset($returnArray [$key]);
			endif;
		}
		return $returnArray;
	}
}

if(! function_exists ( 'roundFloat' )){
	function roundFloat($valor, $decimais) {
		$result = round($valor, $decimais);
		return $result;
	}
}

if(! function_exists ( 'sqlAND' )){
	function sqlAND($sql) {
		if (trim($sql) == '')
			return $sql;
		else
			return $sql . ' AND ';
	}
}

if(! function_exists ( 'somenteNumeros' )){
	function somenteNumeros($valor) {
		return $valor;
	}
}

if(! function_exists ( 'rPad' )){
	function rPad($texto, $tamanho, $caracter = ' ') {
		return str_pad($texto, $tamanho, $caracter);
	}
}

if(! function_exists ( 'stringToBool' )){
	function stringToBool($valor) {
		if (trim($valor) == 'S')
			return true;
		else
			return false;
	}
}

if(! function_exists ( 'stringToData' )){
	function stringToData($data) {
		if ( strstr($data,'/') ): 
			$d = 0;
			$m = 0;
			$y = 0;
			sscanf($data,'%d/%d/%d',$d,$m,$y);
			return sprintf('%d-%d-%d',$y,$m,$d);
		else:
			return $data;
		endif;
	}
}

if(! function_exists ( 'formataLabel' )){
	function formataLabel($palavra) {
		$retorno = substr ( $palavra, (4 - strlen ( $palavra )) );
		$retorno = str_replace ( '_', ' ', $retorno );
		$retorno = acentuar($retorno);
		return ucfirst ( $retorno );
	}
}

if(! function_exists ( 'formataTabela' )){
	function formataTabela($nome) {
		$retorno = str_replace ( '_', ' ', $nome );
		$retorno = acentuar($retorno);
		return ucfirst ( $retorno );
	}
}

if(! function_exists ( 'formatMaskText' )){
	function formatMaskText($mask, $texto){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++):
			if ( $mask[$i] == '#' ):
				if ( isset ( $texto[$k] ) ):
					$maskared .= $texto[$k++];
				endif;
			else:
				if ( isset ( $mask[$i] ) ):
					$maskared .= $mask[$i];
				endif;
			endif;
		endfor;
		
		return $maskared;
	}
}

if(! function_exists ( 'whereSQL' )){
	function whereSQL($sql) {
		if (trim($sql) == '')
			return $sql;
		else
			return ' WHERE ' . $sql;
	}
}

if(! function_exists ( 'getTipoFrete' )){
	function getTipoFrete($tipo) {
		if ($tipo == 'C')
			return 'Pago';
		elseif ($tipo == 'F')
			return 'A pagar';
		elseif ($tipo == 'T')
			return 'Terceiro';
		elseif ($tipo == 'D')
			return 'A definir';
		else
			return 'Sem frete';
	}
}
		
if(! function_exists ( 'getSistema' )){
	function getSistema($sistema) {
		if ( $sistema == SIS_SIS )
			return 'SIS_SIS';
		elseif ( $sistema == SIS_VEN )
			return 'SIS_VEN';
		elseif ( $sistema == SIS_ESQ )
			return 'SIS_ESQ';
		elseif ( $sistema == WEB_VEN )
			return 'WEB_VEN';
		else 
			return 'X';
	}
}

if(! function_exists ( 'getOptionsUF' )){
  function getOptionsUF($uf) {
	$estados= array(''=> 'Selecione',
			'AL'=>'Alagoas',
			'AP'=>'Amap�',
			'AM'=>'Amazonas',
			'BA'=>'Bahia',
			'CE'=>'Cear�',
			'DF'=>'Distrito Federal',
			'ES'=>'Esp�rito Santo',
			'GO'=>'Goi�s',
			'MA'=>'Maranh�o',
			'MS'=>'Mato Grosso do Sul',
			'MT'=>'Mato Grosso',
			'MG'=>'Minas Gerais',
			'PA'=>'Par�',
			'PB'=>'Para�ba',
			'PR'=>'Paran�',
			'PE'=>'Pernambuco',
			'PI'=>'Piau�',
			'RJ'=>'Rio de Janeiro',
			'RN'=>'Rio Grande do Norte',
			'RS'=>'Rio Grande do Sul',
			'RO'=>'Rond�nia',
			'RR'=>'Roraima',
			'SC'=>'Santa Catarina',
			'SP'=>'S�o Paulo',
			'SE'=>'Sergipe',
			'TO'=>'Tocantins');
	$retorno = '';
	foreach ($estados as $key => $value) {
		$checked = ($key==$uf)?'selected="selected"':'';
		$retorno .= "<option {$checked} value='{$key}'>{$value}</option>";
	}
	return $retorno;
  }
}

if(! function_exists ( 'validaCPF' )){
	function validaCPF($valor)
	{
		if(strlen($valor) > 11)
			return false;	
		
		$pArray_cpf = array(10, 9, 8, 7, 6, 5, 4, 3, 2);
		$sArray_cpf = array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2);
		
		$somador_cpf = 0;
		for($i = 0; $i < (strlen($valor) - 2); $i++)
		{
		$somador_cpf = $somador_cpf + ($valor[$i] * $pArray_cpf[$i]);
		}
	
		$auxiliar = $somador_cpf % 11;
		$p_digito_verificador = 11 - $auxiliar;
	
		if($p_digito_verificador < 2)
			$p_digito_verificador = 0;
	
			if($p_digito_verificador == $valor[9])
			{
	
			$somador_cpf = 0;
			for($i = 0; $i < (strlen($valor) - 1); $i++)
			{
			$somador_cpf = $somador_cpf + ($valor[$i] * $sArray_cpf[$i]);
			}
	
				$auxiliar = $somador_cpf % 11;
				$s_digito_verificador = 11 - $auxiliar;
	
				if($s_digito_verificador < 2)
					$s_digito_verificador = 0;
	
					if($s_digito_verificador == $valor[10])
					{
					return true;
			}
			else
			{
			$erroCPF = 2; // Erro no segundo digito verificador
			return false;
			}
			}
				else
				{
				$erroCPF= 1; // Erro no primeiro digito verificador
				return false;
				}
	
	
	}
}

if(! function_exists ( 'tipoPostgres2PHP' )){
	function tipoPostgres2PHP($tipo){
		if ( ($tipo == 'VARCHAR2') or ($tipo == 'CHAR') or ($tipo == 'VARCHAR') or ($tipo == 'TEXT') ):
			return TCCARACTER;
		elseif ( $tipo == 'DATE' ):
			return TCDATA;
		elseif ( $tipo == 'TIMESTAMP' ):
			return TCDATAHORA;
		elseif ( ($tipo == 'NUMBER') or ($tipo == 'NUMERIC') ):
			return  TCNUMERO;
		else:
			return TCCARACTER;
		endif;
	}
}
//Trunca uma string pelo tamanho
if(! function_exists ( 'limitarPDF' )){
	function limitarPDF($string, $tamanho) {
		$letras = array(
				'Q' => 9,
			'W' => 11,
			'E' => 8,
			'R' => 9,
			'T' => 7,
			'Y' => 7,
			'U' => 9,
			'I' => 3,
			'O' => 9,
			'P' => 8,
			'A' => 7,
			'S' => 8,
			'D' => 9,
			'F' => 7,
			'G' => 9,
			'H' => 9,
			'J' => 6,
			'K' => 8,
			'L' => 7,
			'Z' => 7,
			'X' => 7,
			'C' => 9,
			'V' => 7,
			'B' => 8,
			'N' => 9,
			'M' => 9,
			' ' => 2,
			'!' => 3,
			'@' => 12,
			'#' => 7,
			'$' => 7,
			'%' => 11,
			'&' => 8,
			'*' => 5,
			'(' => 4,
			')' => 4,
			'-' => 4,
			'+' => 7,
			"'" => 2
		);

		$tam_tot = 0;
		for($i = 0; $i < strlen($string); $i++):
			$tam_tot += $letras[substr($string, $i, 1)];
			
			if($tam_tot >= ($tamanho - 12)){
				return substr($string, 0, ($i-1)).'...';
			}
			
		endfor;

		return $string;
	}
}

if(! function_exists ( 'validaCNPJ' )){
	function validaCNPJ($cnpj)
	 	{
			//Etapa 1: Cria um array com apenas os digitos num�ricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
			$j=0;
			for($i=0; $i<(strlen($cnpj)); $i++)
				{
					if(is_numeric($cnpj[$i]))
						{
							$num[$j]=$cnpj[$i];
							$j++;
						}
				}
			//Etapa 2: Conta os d�gitos, um Cnpj v�lido possui 14 d�gitos num�ricos.
			if(count($num)!=14)
				{
					$isCnpjValid=false;
				}
			//Etapa 3: O n�mero 00000000000 embora n�o seja um cnpj real resultaria um cnpj v�lido ap�s o calculo dos d�gitos verificadores e por isso precisa ser filtradas nesta etapa.
			if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
				{
					$isCnpjValid=false;
				}
			//Etapa 4: Calcula e compara o primeiro d�gito verificador.
			else
				{
					$j=5;
					for($i=0; $i<4; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=4; $i<12; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[12])
						{
							$isCnpjValid=false;
						} 
				}
			//Etapa 5: Calcula e compara o segundo d�gito verificador.
			if(!isset($isCnpjValid))
				{
					$j=6;
					for($i=0; $i<5; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=5; $i<13; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[13])
						{
							$isCnpjValid=false;
						}
					else
						{
							$isCnpjValid=true;
						}
				}
			//Trecho usado para depurar erros.
			/*
			if($isCnpjValid==true)
				{
					echo "<p><font color="GREEN">Cnpj � V�lido</font></p>";
				}
			if($isCnpjValid==false)
				{
					echo "<p><font color="RED">Cnpj Inv�lido</font></p>";
				}
			*/
			//Etapa 6: Retorna o Resultado em um valor booleano.
			return $isCnpjValid;			
		}
}