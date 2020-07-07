//Função que valida NIS (Número de Identificação Social)
function validaNIS(strNIS)
{
	var intSoma, intMulti, intValor;
	var blnResult = false, intDig, intResto, intInd;
					
	//Verificando o tamanho do NIS
	if((strNIS.length == 11) && ((strNIS.charAt(0) == '1') || (strNIS.charAt(0) == '2')))
	{
		//Calculando o dígito verificador
		if(eval(parseInt(strNIS.substring(0, 10))))
		{
			intValor = parseInt(strNIS.substring(0, 10));
							
			intSoma = 0;
			for(intInd = 2; intInd < 12; intInd++)
			{
				intMulti = intInd;
								
				if(intInd == 10)
				{
					intMulti = 2;
				}
				else if(intInd == 11)
				{
					intMulti = 3;
				}
								
				intSoma += ((intValor % 10) * intMulti);
				intValor = parseInt(intValor / 10);
			}
							
			intResto = intSoma % 11;
			if(intResto > 1)
			{
				intDig = 11 - intResto;
			}
			else
			{
				intDig = 0;
			}
							
			if(eval(parseInt(strNIS.charAt(10))))
			{
				if(intDig == parseInt(strNIS.charAt(10)))
				{
					blnResult = true;
				}
			}
			else if(intDig == parseInt(strNIS.charAt(10)))
			{
				blnResult = true;
			}
		}
	}
					
	//Retornando o resultado
	return(blnResult);
}