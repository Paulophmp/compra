				function validaData(stringData)
				{
				    /******** VALIDA DATA NO FORMATO DD/MM/AAAA *******/
				    
				    var regExpCaracter = /[^\d]/;     //Express�o regular para procurar caracter n�o-num�rico.
				    var regExpEspaco = /^\s+|\s+$/g;  //Express�o regular para retirar espa�os em branco.
				    
				    if(stringData.length != 10)
				    {
				        return false;
				    }
				    
				    splitData = stringData.split('/');
				    
				    if(splitData.length != 3)
				    {
				        return false;
				    }
				    
				    /* Retira os espa�os em branco do in�cio e fim de cada string. */
				    splitData[0] = splitData[0].replace(regExpEspaco, '');
				    splitData[1] = splitData[1].replace(regExpEspaco, '');
				    splitData[2] = splitData[2].replace(regExpEspaco, '');
				    
				    if ((splitData[0].length != 2) || (splitData[1].length != 2) || (splitData[2].length != 4))
				    {
				        return false;
				    }
				    
				    /* Procura por caracter n�o-num�rico. EX.: o "x" em "28/09/2x11" */
				    if (regExpCaracter.test(splitData[0]) || regExpCaracter.test(splitData[1]) || regExpCaracter.test(splitData[2]))
				    {
				        return false;
				    }
				    
				    dia = parseInt(splitData[0],10);
				    mes = parseInt(splitData[1],10)-1; //O JavaScript representa o m�s de 0 a 11 (0->janeiro, 1->fevereiro... 11->dezembro)
				    ano = parseInt(splitData[2],10);
				    
				    if (ano < 1900) {

				    	return false;

				    }

				    var novaData = new Date(ano, mes, dia);
				    
				    /* O JavaScript aceita criar datas com, por exemplo, m�s=14, por�m a cada 12 meses mais um ano � acrescentado � data
				         final e o restante representa o m�s. O mesmo ocorre para os dias, sendo maior que o n�mero de dias do m�s em
				         quest�o o JavaScript o converter� para meses/anos.
				         Por exemplo, a data 28/14/2011 (que seria o comando "new Date(2011,13,28)", pois o m�s � representado de 0 a 11)
				         o JavaScript converter� para 28/02/2012.
				         Dessa forma, se o dia, m�s ou ano da data resultante do comando "new Date()" for diferente do dia, m�s e ano da
				         data que est� sendo testada esta data � inv�lida. */
				    if ((novaData.getDate() != dia) || (novaData.getMonth() != mes) || (novaData.getFullYear() != ano))
				    {
				        return false;
				    }
				    else
				    {

				        return true;
				    }
				}


				function validacaoEmail(email) {

					usuario = email.substring(0, email.indexOf("@"));
					dominio = email.substring(email.indexOf("@")+ 1, email.length);

					if ((usuario.length >=1) &&
					    (dominio.length >=3) && 
					    (usuario.search("@")==-1) && 
					    (dominio.search("@")==-1) &&
					    (usuario.search(" ")==-1) && 
					    (dominio.search(" ")==-1) &&
					    (dominio.search(".")!=-1) &&      
					    (dominio.indexOf(".") >=1)&& 
					    (dominio.lastIndexOf(".") < dominio.length - 1)) {

						return true;
					}
					else{


						return false;
					}
				}
