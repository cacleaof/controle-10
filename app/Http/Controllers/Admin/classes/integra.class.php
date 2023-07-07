<?php


	include(__DIR__ . "/../classes/httpful.phar");
	require_once('JSONMin.php');
	use t1st3\JSONMin\JSONMin as jsonMin;
	use Httpful\Request;
	

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	/**
	* Classe responsável por armazenar as constantes dos tipo de dados aceitados pelo webservice.
	*/
	class TipoDeDados {
		const JSON = 0; // TiposDeDados::JSON
		const XML = 1; //  TiposDeDados::XML
	}

	/**
	* Classe responsável por empacotar os dados e os enviar para o webservice.
	*/
	class Integra {
		private $token_autenticacao = null;

		/**
		* Inicializa uma nova instância da classe com o token de autenticação do Usuário do SMART.
		* @param string $token_autenticacao
		*/
		public function __construct($token_autenticacao) {
			$this->token_autenticacao = $token_autenticacao;
		}

		/**
		* Seta o token de autenticação do Usuário do SMART.
		* @param string $token_autenticacao
		*/
		public function setTokenAutenticacao($token_autenticacao) {
			$this->token_autenticacao = $token_autenticacao;
		}

		/**
		* Método utilizado para enviar dados no formato bruto (JSON ou XML) para o webservice.
		* @param TipoDeDados $tipoDeDados
		* @param string $url
		* @param string $dados
		*/
		public function enviarDados($tipoDeDados, $url, $dados) {
			if ($this->token_autenticacao != null || $this->token_autenticacao != "") {
				//dd($dados);
				if ($tipoDeDados == TipoDeDados::JSON) {
					
					try {
						$response = \Httpful\Request::post($url)->addHeader("Authorization", "Token " .$this->token_autenticacao)->sendsJson()->body($dados)->send();
						//$response= ($url.$this->token_autenticacao.$dados);
						
						return $response;
					} catch (Exception $e) {
						throw new Exception("Atenção: Não foi possível conectar-se à URL informada.");
					}
				} else {
					throw new Exception("O formato XML ainda não foi implementado.");
				}
			} else {
				throw new Exception("Atenção: Você precisa setar o token de autenticação.");
			}
		}

		/**
		* Converte os indicadores no tipo do formato aceito pelo webservice.
		* @param TipoDeDados $tipoDeDados
		* @param string $dados
		*/
		public static function serializar($tipoDeDados, $dados) {
			if ($tipoDeDados == TipoDeDados::JSON) {
				try {
					$json = json_encode($dados);
					return $json;
				} catch (Exception $e) {
					throw new Exception("Atenção: Não foi possível serializar os dados para o formato JSON.");
				}
			} else {
				throw new Exception("O formato XML ainda não foi implementado.");
			}
		}

		/**
		* Método responsável por validar se o valor informado é branco ou nulo.
		* @param string $valor
		*/
		public static function isBlankOrNull($valor) {
			return $valor == trim('') || $valor == null;
		}

		/**
		* Método responsável por validar se o valor informado é uma data no formato indicado.
		* @param string $date
		* @param string $format
		*/
		public static function validateDate($date, $format = 'd/m/Y H:i:s') {
		    $d = DateTime::createFromFormat($format, $date);
		    return $d && $d->format($format) == $date;
		}

		/**
		* Método utilizado para validar o Mês de Refência informado no construtor da classe Integra.
		* @param string $data
		*/
		public static function validateDataReferencia($data) {
			if (checkdate(substr($data, 0, 2), "01", substr($data, 2, 6))) {
				return $data;
			} else {
				throw new Exception("Atenção: A data informada não é valida. Informe no formato \"MMAAAA\".");
			}
		}
	}

	/**
	* Classe responsável por atualizar as informações dos Estabelecimentos de Saúde.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class EstabelecimentoSaude {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $estabelecimentos = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adiciona o estabelecimento de saúde que será atualizado
		* @param string $codigo_cnes		Código CNES do estabelecimento de saúde no qual o profissional solicitante atua
	  * @param boolean $cadastrado_servico_teleconsultoria		Se o estabelecimento consome serviço de Teleconsultoria
	  * @param boolean $cadastrado_servico_teleeducacao		Se o estabelecimento consome serviço de tele-educação
	  * @param boolean $cadastrado_servico_telediagnostico		Se o estabelecimento consome serviço de Telediagnóstico
		* @since ATENÇÃO: Deve ser utilizada a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function atualizarEstabelecimentoSaude($codigo_cnes, $cadastrado_servico_teleconsultoria, $cadastrado_servico_teleeducacao, $cadastrado_servico_telediagnostico) {
			$estabelecimento_saude = new stdClass();

			$estabelecimento_saude->cnes = $codigo_cnes;
			$estabelecimento_saude->tconsul = $cadastrado_servico_teleconsultoria ? "1" : "0";
			$estabelecimento_saude->teduca = $cadastrado_servico_teleeducacao ? "1" : "0";
			$estabelecimento_saude->tdiagn = $cadastrado_servico_telediagnostico ? "1" : "0";

			array_push($this->estabelecimentos, $estabelecimento_saude);
		}
	}

	/**
	* Representa uma coleção de dados cadastrais de equipes de saúde.
	*/
	class EquipesSaude {
		public $lista_equipes_saude = array();

		/**
		* Adiciona os dados cadastrais de uma equipe de saúde.
		* @param string $codigo_nucleo
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $nome
		* @param string $cnes_estabelecimento
		* @param string $codigo_tipo_equipe
		*/
		public function addEquipeSaude($codigo_nucleo, $codigo_equipe, $codigo_equipe_ine, $nome, $cnes_estabelecimento, $codigo_tipo_equipe) {
			$equipe_saude = new stdClass();

			$equipe_saude->codigo_nucleo = $codigo_nucleo;
			$equipe_saude->nome = $nome;
			$equipe_saude->cnes_estabelecimento = $cnes_estabelecimento;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$equipe_saude->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$equipe_saude->codigo_equipe_ine = $codigo_equipe_ine;
			}

			if (!Integra::isBlankOrNull($codigo_tipo_equipe)) {
				$equipe_saude->codigo_tipo_equipe = $codigo_tipo_equipe;
			}

			array_push($this->lista_equipes_saude, $equipe_saude);
		}
	}

	/**
	* Classe responsável por cadastrar/atualizar os dados de profissional de saúde.
  * Quando o SMART recebe um CPF ele tentará busca na base e se não encontrado irá busca na base do CNES.
  * Esse serviço só será utilizado caso o SMART não consiga encontrar o profissional pelo CPF informado nos outros serviços
	* @author Allyson Barros
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class ProfissionalSaude {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $profissionais = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adiciona os dados cadastrais de um profissional de saúde.
		* @param string $codigo_cns		CPF do profissional
		* @param string $codigo_cpf		(opcional) CNS do profissional
		* @param string $nome		Nome do profissional
		* @param string $estabelecimento		Código CNES do estabelecimento de saúde no qual o profissional solicitante atua
		* @param string $ocupacao		Código CBO da ocupação. Consultar lista de CBOs dispnonível no SMART através no menu "Cadastros Gerais > Especialidades (CBO)".
		* @param string $equipe_ine		(opcional) Código INE da equipe de saúde na qual o profissional faz parte.
		* @param string $tipo_profissional		Código do tipo de profissional. Consultar lista de tipos deprofissionais dispnonível no SMART através no menu "Cadastros Gerais > Tipos de Profissionais".
		* @param string $sexo
		*/
		public function addProfissionalSaude($codigo_cns, $codigo_cpf, $nome, $estabelecimento, $ocupacao, $equipe_ine, $tipo_profissional, $sexo) {
			$profisional_saude = new stdClass();

			$profisional_saude->cns = $codigo_cns;
			$profisional_saude->cpf = $codigo_cpf;
			$profisional_saude->nome = $nome;
			$profisional_saude->cnes = $estabelecimento;
			$profisional_saude->cbo = $ocupacao;
			$profisional_saude->ine = $equipe_ine;
			$profisional_saude->tprof = $tipo_profissional;
			$profisional_saude->sexo = $sexo;

			array_push($this->profissionais, $profisional_saude);
		}
	}

	/**
	* Determina quais são os indicadore (quadros) a serem enviados.
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class IndicadorGeral {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $quadro_um = null;
		public $quadro_dois = null;
		public $quadro_tres = null;
		public $quadro_quatro = null;
		public $quadro_cinco = null;
		public $quadro_seis = null;

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param string $codigo_nucleo
		* @param string $mes_referencia
		* @param string $quadro_um
		* @param string $quadro_dois
		* @param string $quadro_tres
		* @param string $quadro_quatro
		* @param string $quadro_cinco
		* @param string $quadro_seis
		*/
		public function __construct($codigo_nucleo, $mes_referencia, $quadro_um, $quadro_dois, $quadro_tres, $quadro_quatro, $quadro_cinco, $quadro_seis) {
			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);

			if ($quadro_um != null) {
					$this->quadro_um = $quadro_um;
			}

			if ($quadro_dois != null) {
					$this->quadro_dois = $quadro_dois;
			}

			if ($quadro_tres != null) {
					$this->quadro_tres = $quadro_tres;
			}

			if ($quadro_quatro != null) {
					$this->quadro_quatro = $quadro_quatro;
			}

			if ($quadro_cinco != null) {
					$this->quadro_cinco = $quadro_cinco;
			}

			if ($quadro_seis != null) {
					$this->quadro_seis = $quadro_seis;
			}
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 1 (Indicadores de estrutura
	* para monitoramento e avaliação do Programa Nacional Telessaúde Brasil Redes).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroUm {
		public $num_profissionais_qualificados = 0;
		public $num_dispositivos_movel = 0;
		public $num_dispositivos_fixo = 0;
		public $avaliacao_estrutura_municipio = array();
		public $profissionais_registrados = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param string $num_profissionais_qualificados
		* @param string $num_dispositivos_movel
		* @param string $num_dispositivos_fixo
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($num_profissionais_qualificados, $num_dispositivos_movel, $num_dispositivos_fixo) {
			$this->num_profissionais_qualificados = $num_profissionais_qualificados;
			$this->num_dispositivos_movel = $num_dispositivos_movel;
			$this->num_dispositivos_fixo = $num_dispositivos_fixo;
		}

		/**
		* Adiciona indicadores (numPontosEmImplantacao, numPontosImplantados e numEquipesSaude)
		* em cada município (codigoMunicipio).
		* @param string $codigo_municipio
		* @param string $num_ubs_pontos_em_implantacao
		* @param string $num_ubs_pontos_implantados
		* @param string $num_equipe_saude_atendidas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAvaliacaoEstrutura($codigo_municipio, $num_ubs_pontos_em_implantacao, $num_ubs_pontos_implantados, $num_equipe_saude_atendidas) {
			$avaliacao_estrutura_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			$avaliacao_estrutura_municipio->codigo_municipio = $codigo_municipio;
			$avaliacao_estrutura_municipio->num_ubs_pontos_em_implantacao = $num_ubs_pontos_em_implantacao;
			$avaliacao_estrutura_municipio->num_ubs_pontos_implantados = $num_ubs_pontos_implantados;
			$avaliacao_estrutura_municipio->num_equipe_saude_atendidas = $num_equipe_saude_atendidas;

			array_push($this->avaliacao_estrutura_municipio, $avaliacao_estrutura_municipio);
		}

		/**
		* Adiciona o indicador "Número de profissionais registrados em cada município (codigoMunicipio)
		* e em cada categoria profissional (codigoFamiliaCBO)".
		* @param string $codigo_municipio
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addProfissionaisRegistrados($codigo_municipio, $codigo_familia_cbo, $numero) {
			$profissionais_registrados = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			$profissionais_registrados->codigo_municipio = $codigo_municipio;
			$profissionais_registrados->codigo_familia_cbo = $codigo_familia_cbo;
			$profissionais_registrados->numero = $numero;

			array_push($this->profissionais_registrados, $profissionais_registrados);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 2 (Indicadores mínimos de processo
	* para monitoramento e avaliação de Teleconsultoria).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroDois {
		public $num_sincronas = 0;
		public $num_assincronas = 0;
		public $num_pontos_ativos = 0;
		public $percentual_aprovado_cib = 0.0;
		public $solicitacoes_uf = array();
		public $solicitacoes_municipio = array();
		public $solicitacoes_equipe = array();
		public $solicitacoes_membro = array();
		public $solicitacoes_ponto = array();
		public $solicitacoes_profissional = array();
		public $solicitacoes_tema_profissional = array();
		public $solicitacoes_cat_profissional = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param string $num_sincronas
		* @param string $num_assincronas
		* @param string $num_pontos_ativos
		* @param Double $percentual_aprovado_cib
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($num_sincronas, $num_assincronas, $num_pontos_ativos, $percentual_aprovado_cib) {
			$this->num_sincronas = $num_sincronas;
			$this->num_assincronas = $num_assincronas;
			$this->num_pontos_ativos = $num_pontos_ativos;
			$this->percentual_aprovado_cib = $percentual_aprovado_cib;
		}

		/**
		* Adiciona o indicador "Número de solicitações de teleconsultorias no estado (codigoUF) respondidas".
		* @param string $codigo_uf
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesUF($codigo_uf, $numero) {
			$solicitacoes_uf = new stdClass();
			$solicitacoes_uf->codigo_uf = $codigo_uf;
			$solicitacoes_uf->numero = $numero;

			array_push($this->solicitacoes_uf, $solicitacoes_uf);
		}

		/**
		* Adiciona o indicador "Número de solicitações de teleconsultorias por município (codigoMunicipio) respondidas".
		* @param string $codigo_municipio
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesMunicipio($codigo_municipio, $numero) {
			$solicitacoes_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			$solicitacoes_municipio->codigo_municipio = $codigo_municipio;
			$solicitacoes_municipio->numero = $numero;

			array_push($this->solicitacoes_municipio, $solicitacoes_municipio);
		}

		/**
		* Adiciona o indicador "Número de solicitações de teleconsultorias por equipe de saúde respondidas".
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesEquipe($codigo_equipe, $codigo_equipe_ine, $numero) {
			$solicitacoes_equipe = new stdClass();
			$solicitacoes_equipe->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$solicitacoes_equipe->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$solicitacoes_equipe->codigo_equipe_ine = $codigo_equipe_ine;
			}

			array_push($this->solicitacoes_equipe, $solicitacoes_equipe);
		}

		/**
		* Adiciona o indicador "Número de solicitações de teleconsultorias por membro de gestão respondidas".
		* @param string $codigo_cpf
		* @param string $codigo_cns
		* @param string $email
		* @param string $membro_nome
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesMembroGestao($codigo_cpf, $codigo_cns, $email, $membro_nome, $numero) {
			$solicitacoes_membro = new stdClass();

			$solicitacoes_membro->email = $email;
			$solicitacoes_membro->membro_nome = $membro_nome;
			$solicitacoes_membro->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_cpf)) {
				$solicitacoes_membro->codigo_cpf = $codigo_cpf;
			}

			if (!Integra::isBlankOrNull($codigo_cns)) {
				$solicitacoes_membro->codigo_cns = $codigo_cns;
			}

			array_push($this->solicitacoes_membro, $solicitacoes_membro);
		}

		/**
		* Adiciona o indicador "Número de solicitações de teleconsultorias por ponto (codigoPontoTelessaude) respondidas."
		* @param string $codigo_ponto
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesPontoTelessaude($codigo_ponto, $numero) {
			$solicitacoes_ponto = new stdClass();
			$solicitacoes_ponto->codigo_ponto = $codigo_ponto;
			$solicitacoes_ponto->numero = $numero;

			array_push($this->solicitacoes_ponto, $solicitacoes_ponto);
		}

		/**
		* Adiciona o indicador "Número total de solicitações por profissional respondidas".
		* @param string $profissional_cpf
		* @param string $profissional_codigo_cns
		* @param string $nome
		* @param string $email
		* @param string $codigo_tipo_profissional
		* @param string $codigo_cbo
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesProfissional($profissional_cpf, $profissional_codigo_cns, $nome, $email, $codigo_tipo_profissional, $codigo_cbo, $codigo_equipe, $codigo_equipe_ine, $numero) {
			$solicitacoes_profissional = new stdClass();

			$solicitacoes_profissional->nome = $nome;
			$solicitacoes_profissional->profissional_email = $email;
			$solicitacoes_profissional->codigo_tipo_profissional = $codigo_tipo_profissional;
			$solicitacoes_profissional->codigo_cbo = $codigo_cbo;
			$solicitacoes_profissional->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$solicitacoes_profissional->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$solicitacoes_profissional->codigo_equipe_ine = $codigo_equipe_ine;
			}

			if (!Integra::isBlankOrNull($profissional_cpf)) {
				$solicitacoes_profissional->profissional_cpf = $profissional_cpf;
			}

			if (!Integra::isBlankOrNull($profissional_codigo_cns)) {
				$solicitacoes_profissional->profissional_codigo_cns = $profissional_codigo_cns;
			}

			array_push($this->solicitacoes_profissional, $solicitacoes_profissional);
		}

		/**
		* Adiciona o indicador "Número total de solicitações por Profissional de saúde e por tema (CID e/ou CIAP2) respondidas".
		*
		* Observações:
		*      1. profissional_cpf, profissional_codigo_cns e profissional_email são utilizados para localizar o profissional de saúde, ao menos um dos três deve ser informado.
		*      2. Ao menos codigo_cid ou codigo_ciap deve ser informado.
		*
		* @param $profissional_cpf          CPF  do profissional
		* @param $profissional_codigo_cns   Identificador CNS do profissional
		* @param $profissional_email        Email do profissional
		* @param $codigo_cid                Código CID (Classificação Internacional de Doenças).
		* @param $codigo_ciap               Código CIAP (Classificação Internacional de Assistência Primária).
		* @param $numero                    Valor do indicador.
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesProfissionalTema($profissional_cpf, $profissional_codigo_cns, $profissional_email, $codigo_cid, $codigo_ciap, $numero) {
			$solicitacoes_tema_profissional = new stdClass();

			$solicitacoes_tema_profissional->profissional_email = $profissional_email;
			$solicitacoes_tema_profissional->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_cid)) {
				$solicitacoes_tema_profissional->codigo_cid = $codigo_cid;
			}

			if (!Integra::isBlankOrNull($codigo_ciap)) {
				$solicitacoes_tema_profissional->codigo_ciap = $codigo_ciap;
			}

			if (!Integra::isBlankOrNull($profissional_cpf)) {
				$solicitacoes_tema_profissional->profissional_cpf = $profissional_cpf;
			}

			if (!Integra::isBlankOrNull($profissional_codigo_cns)) {
				$solicitacoes_tema_profissional->profissional_codigo_cns = $profissional_codigo_cns;
			}

			array_push($this->solicitacoes_tema_profissional, $solicitacoes_tema_profissional);

		}

		/**
		* Adiciona o indicador "Número de solicitações de solicitações por categoria profissional respondidas".
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesCatProfissional($codigo_familia_cbo, $numero) {
			$solicitacoes_cat_profissional = new stdClass();

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			$solicitacoes_cat_profissional->codigo_familia_cbo = $codigo_familia_cbo;
			$solicitacoes_cat_profissional->numero = $numero;

			array_push($this->solicitacoes_cat_profissional, $solicitacoes_cat_profissional);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 3 (Indicadores mínimos de processo
	* para monitoramento e avaliação de Telediagnóstico).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroTres {
		public $num_pontos_ativos = 0;
		public $porcentual_aprovado_cib = 0.0;
		public $solicitacoes_telediagnostico_uf = array();
		public $solicitacoes_telediagnostico_municipio = array();
		public $solicitacoes_telediagnostico_equipe = array();
		public $solicitacoes_telediagnostico_ponto = array();
		public $solicitacoes_telediagnostico_tipo = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param int $num_pontos_ativos
		* @param double $percentual_aprovado_cib
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($num_pontos_ativos, $porcentual_aprovado_cib) {
			$this->num_pontos_ativos = $num_pontos_ativos;
			$this->porcentual_aprovado_cib = $porcentual_aprovado_cib;
		}

		/**
		* Adiciona o indicador "Número de solicitações com exame realizado e laudo enviado ao solicitado por estado (codigoUF)".
		* @param string $codigo_uf
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesTelediagnosticoUF($codigo_uf, $numero) {
			$solicitacoes_telediagnostico_uf = new stdClass();
			$solicitacoes_telediagnostico_uf->codigo_uf = $codigo_uf;
			$solicitacoes_telediagnostico_uf->numero = $numero;

			array_push($this->solicitacoes_telediagnostico_uf, $solicitacoes_telediagnostico_uf);
		}

		/**
		* Adiciona o indicador "Número de solicitações com exame realizado e laudo enviado ao solicitado por município (codigoMunicipio)".
		* @param string $codigo_municipio
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesTelediagnosticoMunicipio($codigo_municipio, $numero) {
			$solicitacoes_telediagnostico_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			$solicitacoes_telediagnostico_municipio->codigo_municipio = $codigo_municipio;
			$solicitacoes_telediagnostico_municipio->numero = $numero;

			array_push($this->solicitacoes_telediagnostico_municipio, $solicitacoes_telediagnostico_municipio);
		}

		/**
		* Adiciona o indicador "Número de solicitações com exame realizado e laudo enviado ao solicitante por equipe".
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesTelediagnosticoEquipe($codigo_equipe, $codigo_equipe_ine, $numero) {
			$solicitacoes_telediagnostico_equipe = new stdClass();
			$solicitacoes_telediagnostico_equipe->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$solicitacoes_telediagnostico_equipe->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$solicitacoes_telediagnostico_equipe->codigo_equipe_ine = $codigo_equipe_ine;
			}

			array_push($this->solicitacoes_telediagnostico_equipe, $solicitacoes_telediagnostico_equipe);
		}

		/**
		* Adiciona o indicador "Número de solicitações com exame realizado e laudo enviado ao solicitante por ponto de telessaúde."
		* @param string $codigo_ponto
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesTelediagnosticoPontoTelessaude($codigo_ponto, $numero) {
			$solicitacoes_telediagnostico_ponto = new stdClass();
			$solicitacoes_telediagnostico_ponto->codigo_ponto = $codigo_ponto;
			$solicitacoes_telediagnostico_ponto->numero = $numero;

			array_push($this->solicitacoes_telediagnostico_ponto, $solicitacoes_telediagnostico_ponto);
		}

		/**
		* Adiciona o indicador "Número de solicitações com exame realizado e laudo enviado ao solicitante por tipo (codigoSIA)."
		* @param string $codigo_sia
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacoesTelediagnosticoTipo($codigo_sia, $numero) {
			$solicitacoes_telediagnostico_tipo = new stdClass();
			$solicitacoes_telediagnostico_tipo->codigo_sia = $codigo_sia;
			$solicitacoes_telediagnostico_tipo->numero = $numero;

			array_push($this->solicitacoes_telediagnostico_tipo, $solicitacoes_telediagnostico_tipo);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 4 (Indicadores mínimos de processo
	* para monitoramento e avaliação de Tele-educação).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroQuatro {
		public $quantidade_disponibilizada_ares = 0;
		public $num_pontos_ativos = 0;
		public $atividades_realizadas_uf = array();
		public $atividades_realizadas_municipio = array();
		public $atividades_realizadas_ponto = array();
		public $atividades_realizadas_equipe = array();
		public $participantes_cat_profissional_uf = array();
		public $participantes_cat_profissional_municipio = array();
		public $participantes_cat_profissional_equipe = array();
		public $participantes_cat_profissional_ponto = array();
		public $acessos_objetos_aprendizagem = array();
		public $acessos_objetos_aprendizagem_municipio = array();
		public $acessos_objetos_aprendizagem_equipe = array();
		public $acessos_objetos_aprendizagem_ponto = array();
		public $acessos_objetos_aprendizagem_cat_profissional = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param string $quantidade_disponibilizada_ares
		* @param string $num_pontos_ativos
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($quantidade_disponibilizada_ares, $num_pontos_ativos) {
			$this->quantidade_disponibilizada_ares = $quantidade_disponibilizada_ares;
			$this->num_pontos_ativos = $num_pontos_ativos;
		}

		/**
		* Adiciona o indicador "Número de atividades realizadas por estado (codigoUF)".
		* @param string $codigo_uf
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAtividadesRealizadasUF($codigo_uf, $numero, $num_sincronas) {
			$atividades_realizadas_uf = new stdClass();
			$atividades_realizadas_uf->codigo_uf = $codigo_uf;
			$atividades_realizadas_uf->numero = $numero;
			$atividades_realizadas_uf->num_sincronas = $num_sincronas;

			array_push($this->atividades_realizadas_uf, $atividades_realizadas_uf);
		}

		/**
		* Adiciona o indicador "Número de atividades realizadas por município (codigoMunicipio)".
		* @param string $codigo_municipio
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAtividadesRealizadasMunicipio($codigo_municipio, $numero, $num_sincronas) {
			$atividades_realizadas_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			$atividades_realizadas_municipio->codigo_municipio = $codigo_municipio;
			$atividades_realizadas_municipio->numero = $numero;
			$atividades_realizadas_municipio->num_sincronas = $num_sincronas;

			array_push($this->atividades_realizadas_municipio, $atividades_realizadas_municipio);
		}

		/**
		* Adiciona o indicador "Número de atividades realizadas por ponto de telessaúde (codigoPontoTelessaude)."
		* @param string $codigo_ponto
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAtividadesRealizadasPontoTelessaude($codigo_ponto, $numero, $num_sincronas) {
			$atividades_realizadas_ponto = new stdClass();
			$atividades_realizadas_ponto->codigo_ponto = $codigo_ponto;
			$atividades_realizadas_ponto->numero = $numero;
			$atividades_realizadas_ponto->num_sincronas = $num_sincronas;

			array_push($this->atividades_realizadas_ponto, $atividades_realizadas_ponto);
		}

		/**
		* Adiciona o indicador "Número de atividades realizdas por equipe".
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAtividadesRealizadasEquipe($codigo_equipe, $codigo_equipe_ine, $numero, $num_sincronas) {
			$atividades_realizadas_equipe = new stdClass();
			$atividades_realizadas_equipe->numero = $numero;
			$atividades_realizadas_equipe->num_sincronas = $num_sincronas;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$atividades_realizadas_equipe->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$atividades_realizadas_equipe->codigo_equipe_ine = $codigo_equipe_ine;
			}

			array_push($this->atividades_realizadas_equipe, $atividades_realizadas_equipe);
		}

		/**
		* Adiciona o indicador "Número de participantes por categoria profissional (codigoFamiliaCBO) por estado (codigoUF)".
		* @param string $codigo_uf
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addParticipantesCatProfissionalUF($codigo_uf, $codigo_familia_cbo, $numero, $num_sincronas) {
			$participantes_cat_profissional_uf = new stdClass();

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			$participantes_cat_profissional_uf->codigo_uf = $codigo_uf;
			$participantes_cat_profissional_uf->codigo_familia_cbo = $codigo_familia_cbo;
			$participantes_cat_profissional_uf->numero = $numero;
			$participantes_cat_profissional_uf->num_sincronas = $num_sincronas;

			array_push($this->participantes_cat_profissional_uf, $participantes_cat_profissional_uf);
		}

		/**
		* Adiciona o indicador "Número de participantes por categoria profissional (codigoFamiliaCBO) por município (codigoMunicipio)".
		* @param string $codigo_municipio
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addParticipantesCatProfissionalMunicipio($codigo_municipio, $codigo_familia_cbo, $numero, $num_sincronas) {
			$participantes_cat_profissional_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			$participantes_cat_profissional_municipio->codigo_municipio = $codigo_municipio;
			$participantes_cat_profissional_municipio->codigo_familia_cbo = $codigo_familia_cbo;
			$participantes_cat_profissional_municipio->numero = $numero;
			$participantes_cat_profissional_municipio->num_sincronas = $num_sincronas;

			array_push($this->participantes_cat_profissional_municipio, $participantes_cat_profissional_municipio);
		}

		/**
		* Adiciona o indicador "Número de participantes por categoria profissional (codigoFamiliaCBO) por equipe".
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addParticipantesCatProfissionalEquipe($codigo_equipe, $codigo_equipe_ine, $codigo_familia_cbo, $numero, $num_sincronas) {
			$participantes_cat_profissional_equipe = new stdClass();
			$participantes_cat_profissional_equipe->codigo_familia_cbo = $codigo_familia_cbo;
			$participantes_cat_profissional_equipe->numero = $numero;
			$participantes_cat_profissional_equipe->num_sincronas = $num_sincronas;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$participantes_cat_profissional_equipe->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$participantes_cat_profissional_equipe->codigo_equipe_ine = $codigo_equipe_ine;
			}

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			array_push($this->participantes_cat_profissional_equipe, $participantes_cat_profissional_equipe);
		}

		/**
		* Adiciona o indicador "Número de participantes por categoria profissional (codigoFamiliaCBO) por ponto/mês (codigoPonto)".
		* @param string $codigo_ponto
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @param string $num_sincronas
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addParticipantesCatProfissionalPontoTelessaude($codigo_ponto, $codigo_familia_cbo, $numero, $num_sincronas) {
			$participantes_cat_profissional_ponto = new stdClass();

			if (strlen($codigo_familia_cbo) > 4)
			throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");

			$participantes_cat_profissional_ponto->codigo_ponto = $codigo_ponto;
			$participantes_cat_profissional_ponto->codigo_familia_cbo = $codigo_familia_cbo;
			$participantes_cat_profissional_ponto->numero = $numero;
			$participantes_cat_profissional_ponto->num_sincronas = $num_sincronas;

			array_push($this->participantes_cat_profissional_ponto, $participantes_cat_profissional_ponto);
		}

		/**
		* Adiciona o indicador "Número global de acessos aos objetos de aprendizagem por estado, município, equipe e ponto/mês".
		* @param string $codigo_uf
		* @param string $codigo_municipio
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $codigo_ponto
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAcessosObjetosAprendizagem($codigo_uf, $codigo_municipio, $codigo_equipe, $codigo_equipe_ine, $codigo_ponto, $numero) {
			$acessos_objetos_aprendizagem = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$acessos_objetos_aprendizagem->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$acessos_objetos_aprendizagem->codigo_equipe_ine = $codigo_equipe_ine;
			}

			$acessos_objetos_aprendizagem->codigo_uf = $codigo_uf;
			$acessos_objetos_aprendizagem->codigo_municipio = $codigo_municipio;
			$acessos_objetos_aprendizagem->codigo_ponto = $codigo_ponto;
			$acessos_objetos_aprendizagem->numero = $numero;

			array_push($this->acessos_objetos_aprendizagem, $acessos_objetos_aprendizagem);
		}

		/**
		* Adiciona o indicador "Número global de acessos aos objetos de aprendizagem por município (codigoMunicipio)".
		* @param string $codigo_municipio
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAcessosObjetosAprendizagemMunicipio($codigo_municipio, $numero) {
			$acessos_objetos_aprendizagem_municipio = new stdClass();

			if (strlen($codigo_municipio) > 6)
			throw new Exception("Atenção: O Código do Município não pode ser maior que 6.");

			$acessos_objetos_aprendizagem_municipio->codigo_municipio = $codigo_municipio;
			$acessos_objetos_aprendizagem_municipio->numero = $numero;

			array_push($this->acessos_objetos_aprendizagem_municipio, $acessos_objetos_aprendizagem_municipio);
		}

		/**
		* Adiciona o indicador "Número global de acessos aos objetos de aprendizagem por equipe".
		* @param string $codigo_equipe
		* @param string $codigo_equipe_ine
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAcessosObjetosAprendizagemEquipe($codigo_equipe, $codigo_equipe_ine, $numero) {
			$acessos_objetos_aprendizagem_equipe = new stdClass();
			$acessos_objetos_aprendizagem_equipe->numero = $numero;

			if (!Integra::isBlankOrNull($codigo_equipe)) {
				$acessos_objetos_aprendizagem_equipe->codigo_equipe = $codigo_equipe;
			}

			if (!Integra::isBlankOrNull($codigo_equipe_ine)) {
				$acessos_objetos_aprendizagem_equipe->codigo_equipe_ine = $codigo_equipe_ine;
			}

			array_push($this->acessos_objetos_aprendizagem_equipe, $acessos_objetos_aprendizagem_equipe);
		}

		/**
		* Adiciona o indicador "Número global de acessos aos objetos de aprendizagem por ponto de telessaúde."
		* @param string $codigo_ponto
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAcessosObjetosAprendizagemPontoTelessaude($codigo_ponto, $numero) {
			$acessos_objetos_aprendizagem_ponto = new stdClass();
			$acessos_objetos_aprendizagem_ponto->codigo_ponto = $codigo_ponto;
			$acessos_objetos_aprendizagem_ponto->numero = $numero;

			array_push($this->acessos_objetos_aprendizagem_ponto, $acessos_objetos_aprendizagem_ponto);
		}

		/**
		* Adiciona o indicador "Número global de acessos aos objetos de aprendizagem por categoria profissional (codigoFamiliaCBO)".
		* @param string $codigo_familia_cbo
		* @param string $numero
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAcessosObjetosAprendizagemCatProfissional($codigo_familia_cbo, $numero) {
			$acessos_objetos_aprendizagem_cat_profissional = new stdClass();

			if (strlen($codigo_familia_cbo) > 4) {
					throw new Exception("Atenção: O Código da família do CBO não pode ser maior que 4.");
			}

			$acessos_objetos_aprendizagem_cat_profissional->codigo_familia_cbo = $codigo_familia_cbo;
			$acessos_objetos_aprendizagem_cat_profissional->numero = $numero;

			array_push($this->acessos_objetos_aprendizagem_cat_profissional, $acessos_objetos_aprendizagem_cat_profissional);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 5 (Indicadores mínimos
	* de resultados e avaliação para monitoramento de Teleconsultoria).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroCinco {
		const SIM = 1;
		const PARCIALMENTE = 2;
		const NAO = 3;
		const NAOSEI = 4;

		public $num_sof_enviada_bireme = 0;
		public $tempo_medio_sincronas = 0;
		public $tempo_medio_assincronas = 0;
		public $percentual_assinc_resp_emmenos72 = 0.0;
		public $satisfacao_solicitante = array();
		public $resolucao_duvida = array();
		public $temas_frequentes = array();
		public $cat_profissionais_frequentes = array();
		public $especialidades_frequentes = array();
		public $evitacao_encaminhamentos = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param string $num_sof_enviada_bireme
		* @param Double $tempo_medio_sincronas
		* @param Double $tempo_medio_assincronas
		* @param Double $percentual_assinc_resp_emmenos72
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($num_sof_enviada_bireme, $tempo_medio_sincronas, $tempo_medio_assincronas, $percentual_assinc_resp_emmenos72) {
			$this->num_sof_enviada_bireme = $num_sof_enviada_bireme;
			$this->tempo_medio_sincronas = $tempo_medio_sincronas;
			$this->tempo_medio_assincronas = $tempo_medio_assincronas;
			$this->percentual_assinc_resp_emmenos72 = $percentual_assinc_resp_emmenos72;
		}

		/**
		* Adiciona o indicador "Percentual de teleconsultorias respondidas em que houve satisfação do solicitante".
		* @param string $codigo_escala_likert
		* @param Double $percentual
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSatisfacaoSolicitante($codigo_escala_likert, $percentual) {
			$satisfacao_solicitante = new stdClass();
			$satisfacao_solicitante->codigo_escala_likert = $codigo_escala_likert;
			$satisfacao_solicitante->percentual = $percentual;

			array_push($this->satisfacao_solicitante, $satisfacao_solicitante);
		}

		/**
		* Adiciona o indicador "Percentual de teleconsultorias respondidas em que houve resolução da dúvida (sim, parcialmente, não, não sei)".
		* @param Double $percentual_sim
		* @param Double $percentual_parcial
		* @param Double $percentual_nao
		* @param Double $percentual_nao_sei
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addResolucaoDuvida($percentual_sim, $percentual_parcial, $percentual_nao, $percentual_nao_sei) {
			$resolucao_duvida = new stdClass();
			$resolucao_duvida->percentual_sim = $percentual_sim;
			$resolucao_duvida->percentual_parcial = $percentual_parcial;
			$resolucao_duvida->percentual_nao = $percentual_nao;
			$resolucao_duvida->percentual_nao_sei = $percentual_nao_sei;

			array_push($this->resolucao_duvida, $resolucao_duvida);
		}

		/**
		* Adiciona o indicador "Lista dos 10 temas mais frequentes das solicitações de teleconsultorias respondidas".
		* @param string $codigo_cid
		* @param string $codigo_ciap
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addTemasFrequentes($codigo_cid, $codigo_ciap) {
			$temas_frequentes = new stdClass();
			$temas_frequentes->codigo_cid = $codigo_cid;
			$temas_frequentes->codigo_ciap = $codigo_ciap;

			array_push($this->temas_frequentes, $temas_frequentes);
		}

		/**
		* Adiciona o indicador " Categoria profissional dos teleconsultores mais frequentes entre as solicitações de telconsultorias respondidas".
		* @param string $codigo_familia_cbo
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addCatProfissionaisFrequentes($codigo_familia_cbo) {
			$cat_profissionais_frequentes = new stdClass();
			$cat_profissionais_frequentes->codigo_familia_cbo = $codigo_familia_cbo;

			array_push($this->cat_profissionais_frequentes, $cat_profissionais_frequentes);
		}

		/**
		* Adiciona o indicador "Especialidades dos teleconsultores mais frequentes entre as solicitações de telconsultorias respondidas".
		* @param string $codigo_cbo
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addEspecialidadesFrequentes($codigo_cbo) {
			$especialidades_frequentes = new stdClass();
			$especialidades_frequentes->codigo_cbo = $codigo_cbo;

			array_push($this->especialidades_frequentes, $especialidades_frequentes);
		}

		/**
		* % teleconsultorias respondidas que havia intenção de encaminhar paciente em que houve evitação de encaminhamentos".
		* @param string $codigo_familia_cbo
		* @param Double $percentual_sim
		* @param Double $percentual_nao
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addEvitacaoEncaminhamentoCatProfissional($codigo_familia_cbo, $percentual_sim, $percentual_nao) {
			$evitacao_encaminhamento_cat_profissional = new stdClass();
			$evitacao_encaminhamento_cat_profissional->codigo_familia_cbo = $codigo_familia_cbo;
			$evitacao_encaminhamento_cat_profissional->percentual_sim = $percentual_sim;
			$evitacao_encaminhamento_cat_profissional->percentual_nao = $percentual_nao;

			array_push($this->evitacao_encaminhamentos, $evitacao_encaminhamento_cat_profissional);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento do Quadro 6 (Indicadores de resultados e
	* avaliação para a Tele-educação).
	* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class QuadroSeis {
		public $temas_frequentes_participacao = array();
		public $avaliacao_satisfacao_participantes = array();
		public $temas_frequntes_objeto_aprendizagem = array();
		public $avaliacao_satisfacao_objeto_aprendizagem = array();

		/**
		* Inicializa uma nova instância da classe com os indicadores passados nos parâmetros.
		* @param array $temas_frequentes_participacao
		* @param array $avaliacao_satisfacao_participantes
		* @param array $temas_frequntes_objeto_aprendizagem
		* @param array $avaliacao_satisfacao_objeto_aprendizagem
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function __construct($temas_frequentes_participacao, $avaliacao_satisfacao_participantes, $temas_frequntes_objeto_aprendizagem, $avaliacao_satisfacao_objeto_aprendizagem) {
			$this->temas_frequentes_participacao = $temas_frequentes_participacao;
			$this->avaliacao_satisfacao_participantes = $avaliacao_satisfacao_participantes;
			$this->temas_frequntes_objeto_aprendizagem = $temas_frequntes_objeto_aprendizagem;
			$this->avaliacao_satisfacao_objeto_aprendizagem = $avaliacao_satisfacao_objeto_aprendizagem;
		}

		/**
		* Adiciona o indicador "Até 5 temas com maior participação por mês".
		* @param string $codigo_decs_bireme
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addTemasFrequentesParticipacao($codigo_decs_bireme) {
			$temas_frequentes_participacao = new stdClass();
			$temas_frequentes_participacao->codigo_decs_bireme = $codigo_decs_bireme;

			array_push($this->temas_frequentes_participacao, $temas_frequentes_participacao);
		}

		/**
		* Adiciona o indicador "Avaliação global da satisfação dos profissionais participantes do mês".
		* @param string $codigo_escala_likert
		* @param Double $percentual
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAvaliacaoSatisfacaoParticipantes($codigo_escala_likert, $percentual) {
			$avaliacao_satisfacao_participantes = new stdClass();
			$avaliacao_satisfacao_participantes->codigo_escala_likert = $codigo_escala_likert;
			$avaliacao_satisfacao_participantes->percentual = $percentual;

			array_push($this->avaliacao_satisfacao_participantes, $avaliacao_satisfacao_participantes);
		}

		/**
		* Adiciona o indicador " Até 5 temas mais acessados, por objetos de aprendizagem".
		* @param string $codigo_decs_bireme
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addTemasFrequentesObjetoAprendizagem($codigo_decs_bireme) {
			$temas_frequntes_objeto_aprendizagem = new stdClass();
			$temas_frequntes_objeto_aprendizagem->codigo_decs_bireme = $codigo_decs_bireme;

			array_push($this->temas_frequntes_objeto_aprendizagem, $temas_frequntes_objeto_aprendizagem);
		}

		/**
		* Adiciona o indicador " Avaliação global da satisfação profissional com os objetos de aprendizagem por mês".
		* @param string $codigo_escala_likert
		* @param Double $percentual
		* @deprecated obsoleto a partir da versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAvaliacaoSatisfacaoObjetoAprendizagem($codigo_escala_likert, $percentual) {
			$avaliacao_satisfacao_objeto_aprendizagem = new stdClass();
			$avaliacao_satisfacao_objeto_aprendizagem->codigo_escala_likert = $codigo_escala_likert;
			$avaliacao_satisfacao_objeto_aprendizagem->percentual = $percentual;

			array_push($this->avaliacao_satisfacao_objeto_aprendizagem, $avaliacao_satisfacao_objeto_aprendizagem);
		}
	}

	/**
	* Classe responsável por armazenar as constantes dos tipo de Teleconsultoria.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TipoTeleconsultoria {
		const ASSINCRONA = "A";
		const SINCRONA = "S";
	}

	/**
	* Classe responsável por armazenar as constantes dos tipo de Canais de Acesso.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class CanalAcesso {
		const INTERNET = "1";
		const TELEFONE = "2";
	}

	/**
	* Classe responsável por armazenar as constantes do Grau de Satisfação.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class GrauSatisfacao {
		const MUITO_INSATISFEITO = "1";
		const INSATISFEITO = "2";
		const INDIFERENTE = "3";
		const SATISFEITO = "4";
		const MUITO_SATISFEITO = "5";
		const NAO_INFORMADO = "9";
	}

	/**
	* Classe responsável por armazenar as constantes da Resolução de Dúvida de Teleconsultoria.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class ResolucaoDuvidaTeleconsultoria {
		const ATENDEU_TOTALMENTE = "1";
		const ATENDEU_PARCIALMENTE = "2";
		const NAO_ATENDEU = "3";
		const NAO_INFORMADO = "9";
	}

	/**
	* Classe responsável por armazenar as constantes da Intenção de Encaminhamento de Teleconsultoria.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class IntencaoEncaminhamentoTeleconsultoria {
		const NAO = "0";
    const SIM = "1";
    const NAO_INFORMADO = "9";
	}

	/**
	* Classe responsável por armazenar as constantes da Evitação de Encaminhamento de Teleconsultoria.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class EvitouEncaminhamentoTeleconsultoria {
		const NAO = "0";
		const SIM = "1";
		const NAO_INFORMADO = "9";
	}

	/**
	* Classe responsável por armazenar as constantes do Tipo de Atividade de Teleeducação.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TipoAtividade {
		const CURSO = "1";
		const WEBAULAS_PALESTRAS = "2";
		const WEBSEMINARIOS = "3";
		const FORUM = "4";
		const REUNIAO = "5";
	}

	/**
	* Classe responsável por armazenar as constantes do Tipo de Objeto de Aprendizagem.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TipoObjetoAprendizagem {
		const TEXTO = "1";
		const MULTIMIDIA = "2";
		const IMAGENS = "3";
		const APLICATIVOS = "4";
		const JOGOS_EDUCACIONAIS = "5";
		const OUTROS = "6";
	}

	/**
	* Classe responsável por armazenar as constantes do Sexo.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class Sexo {
		const FEMININO = "F";
		const MASCULINO = "M";
	}

	/**
	* Classe responsável por armazenar as solicitações de teleconsultoria.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class Teleconsultoria {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $teleconsultorias = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adiciona a solicitação de teleconsultoria.
		* A teleconsultoria é identificada exclusivamente pela data da solicitação e o cpf do solicitante.
		* @param string $dh_solicitacao		Data/hora da solicitação da teleconsultoria no formato dd/MM/yyyy HH:MM:SS
		* @param TipoTeleconsultoria $tipo		Tipo da solicitação, se Síncrona ou Assíncrona
		* @param CanalAcesso $canal_acesso_sincrona		Canal de acesso, se internet ou telefone
		* @param string $cpf_solicitante		CPF do profissional que solicitou a teleconsultoria
		* @param string $especialidade_solicitante		Código CBO da ocupação do solicitante no momento da solicitação da teleconsultoria
		* @param string $ponto_telessaude_solicitacao		Código CNES do estabelecimento de saúde no qual o profissional solicitante atua
		* @param string $equipe_do_solicitante		Código INE da equipe de saúde na qual o profissional solicitante faz parte
		* @param string $tipo_profissional		Código do tipo de profissional de saúde cadastrado no SMART
		* @param array $cids		Lista com os códigos CID (Classificação Internacional de Doenças).
		* @param array $ciaps		Lista com os códigos CIAP (Classificação Internacional de Assistência Primária).
		* @param string $dh_resposta_solicitacao		Data/hora da resposta da solicitação no formato dd/MM/yyyy HH:MM:SS
		* @param boolean $evitou_encaminhamento		Se a teleconsultoria evitou o encaminhamento de paciente
		* @param boolean $intensao_encaminhamento		Se o profissional registrou na teleconsultoria que tinha intenção de encaminhar o paciente
		* @param GrauSatisfacao $grau_satisfacao		Grau de satisfação do solicitante quanto a resposta da sua teleconsultoria
		* @param ResolucaoDuvidaTeleconsultoria $resolucao_duvida		Se a resposta da teleconsultoria atendeu, atendeu parcialmente ou não atendeu à sua teleconsultoria.
		* @param boolean $potencial_sof		Se a teleconsultoria tem pontencial para transforma em SOF
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacao($dh_solicitacao, $tipo, $canal_acesso_sincrona, $cpf_solicitante, $especialidade_solicitante, $ponto_telessaude_solicitacao, $equipe_do_solicitante, $tipo_profissional, $cids, $ciaps, $dh_resposta_solicitacao, $evitou_encaminhamento, $intensao_encaminhamento, $grau_satisfacao, $resolucao_duvida, $potencial_sof) {
			$teleconsultoria = new stdClass();

			if (!Integra::validateDate($dh_solicitacao)) {
				throw new Exception("A data da solicitação informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			if (!Integra::validateDate($dh_resposta_solicitacao)) {
				throw new Exception("A data da resposta informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$teleconsultoria->dtsol = $dh_solicitacao;
			$teleconsultoria->tipo = $tipo;
			$teleconsultoria->canal = $canal_acesso_sincrona;
			$teleconsultoria->scpf = $cpf_solicitante;
			$teleconsultoria->scbo = $especialidade_solicitante;
			$teleconsultoria->scnes = $ponto_telessaude_solicitacao;
			$teleconsultoria->stipo = $tipo_profissional;

			if (!Integra::isBlankOrNull($equipe_do_solicitante)) {
				$teleconsultoria->sine = $equipe_do_solicitante;
			}

			if (!empty($cids)){
					$teleconsultoria->cids = $cids;
			}

			if (!empty($ciaps)){
					$teleconsultoria->ciaps = $ciaps;
			}

			$teleconsultoria->dtresp = $dh_resposta_solicitacao;
			$teleconsultoria->evenc = $evitou_encaminhamento ? "1" : "0";
			$teleconsultoria->inenc = $intensao_encaminhamento ? "1" : "0";
			$teleconsultoria->satisf = $grau_satisfacao;
			$teleconsultoria->rduvida = $resolucao_duvida;
			$teleconsultoria->psof = $potencial_sof ? "1" : "0";

			array_push($this->teleconsultorias, $teleconsultoria);
		}
	}

	/**
	* Classe com todas as funções necessárias para o recebimento dos dados referentes aos Telediagnósticos do Núcleo.
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	*/
	class Telediagnostico {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $telediagnosticos = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adicona a solicitação do telediagnóstico
		* O SMART considera um telediagnóstico única pela chave  (dataSolicitacao e cpfSolicitante)
		* @param string $dh_realizacao_exame		Data/hora da solicitação do telediagnóstico no formato dd/MM/yyyy HH:MM:SS
		* @param string $codigo_tipo_exame		Código SIA/SIH do tipo do exame
		* @param string $codigo_equipamento		(opcional) Código do equipamento utilizado para realizar o exame de telediagnóstico. Consultar lista de equipamentos dispnonível no SMART através no menu "Cadastros Gerais > Equipamentos".
		* @param string $tipo_justificativa		(opcional) Código da justificativa utilizada caso o código do equipamento não tenha sido informado. Obrigatório se codigoEquipamento não foi fornecido. Consultar lista de justificativas dispnonível no SMART através no menu "Cadastros Gerais > Tipos de Justificativa".
		* @param string $ponto_telessaude_com_telediagnostico		Código CNES do estabelecimento de saúde onde está o equipamento que realiza o exame.
		* @param string $cpf_solicitante		CPF do profissional que solicitou o telediagnóstico.
		* @param string $especialidade_solicitante		Código CBO da ocupação do solicitante no momento da solicitação do Telediagnóstico. Consultar lista de CBOs dispnonível no SMART através no menu "Cadastros Gerais > Especialidades (CBO)".
		* @param string $ponto_telessaude_solicitacao		Código CNES do estabelecimento de saúde no qual o profissional solicitante atua.
		* @param string $dh_laudo		Data/hora da disponibilização do laudo no formato dd/MM/yyyy HH:MM:SS
		* @param string $cpf_laudista		CPF do especialista que elaborou o laudo
		* @param string $especialidade_laudista		Código CBO da ocupação do laudista.
		* @param string $ponto_telessaude_laudista		Código CNES do laudista
		* @param string $cpf_paciente		CPF do paciente
		* @param string $cns_paciente		(opcional) CNS do paciente. Obrigatório se CPF não foi fornecido
		* @param string $cidade_moradia_paciente		Código IBGE sem o dígito verificador da cidade onde o paciente mora.
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addSolicitacao($dh_realizacao_exame, $codigo_tipo_exame, $codigo_equipamento, $tipo_justificativa, $ponto_telessaude_com_telediagnostico, $cpf_solicitante, $especialidade_solicitante, $ponto_telessaude_solicitacao, $dh_laudo, $cpf_laudista, $especialidade_laudista, $ponto_telessaude_laudista, $cpf_paciente, $cns_paciente, $cidade_moradia_paciente) {
			$telediagnostico = new stdClass();

			if (!Integra::validateDate($dh_realizacao_exame)) {
				throw new Exception("A data da realização do exame informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			if (!Integra::validateDate($dh_laudo)) {
				throw new Exception("A data de laudagem informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$telediagnostico->dhrexame = $dh_realizacao_exame;
			$telediagnostico->ctexame = $codigo_tipo_exame;
			$telediagnostico->cequipa = $codigo_equipamento;
			$telediagnostico->tjust = $tipo_justificativa;
			$telediagnostico->pnt = $ponto_telessaude_com_telediagnostico;
			$telediagnostico->scpf = $cpf_solicitante;
			$telediagnostico->scbo = $especialidade_solicitante;
			$telediagnostico->scnes = $ponto_telessaude_solicitacao;
			$telediagnostico->dhla = $dh_laudo;
			$telediagnostico->lcpf = $cpf_laudista;
			$telediagnostico->lcbo = $especialidade_laudista;
			$telediagnostico->lcnes = $ponto_telessaude_laudista;
			$telediagnostico->pcpf = $cpf_paciente;
			$telediagnostico->pacns = $cns_paciente;
			$telediagnostico->paibge = $cidade_moradia_paciente;

			array_push($this->telediagnosticos, $telediagnostico);
		}
	}

	/**
	* Classe responsável por armazenar os dados das Atividades de Tele-educação
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TeleeducacaoAtividade {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $atividades_teleeducacao = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		private function findAtividadeInListByCodigoIdentificacao($codigo_identificacao) {
			$atividade_teleeducacao = null;
			foreach($this->atividades_teleeducacao as $atividade_item) {
			    if ($codigo_identificacao == $atividade_item->id) {
			        $atividade_teleeducacao = $atividade_item;
			        break;
			    }
			}

			if($atividade_teleeducacao == null) {
					throw new Exception("Atividade de Teleeducação não encontrada.");
			} else {
					return $atividade_teleeducacao;
			}
		}

		/**
		* Adiciona os dados das Atividades de Tele-educação
		* @param string $codigo_identificacao		Código único utilizado pelo núcleo para identificar atividade
		* @param string $data_disponibilizacao		Data em que a atividade foi disponibilizada
		* @param string $carga_horaria		Duração da atividade
		* @param TipoAtividade $tipo_atividade		Tipos de atividades educacional conforme previsto na nota técnica 50/2015 DEGES/SGTES/MS.
		* @param string $tema_codigo_decs		Código da classificação do Descritores em Ciências da Saude (DeCS) da BIREME
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addAtividade($codigo_identificacao, $data_disponibilizacao, $carga_horaria, $tipo_atividade, $tema_codigo_decs) {
			$atividade_teleeducacao = new stdClass();

			if (!Integra::validateDate($data_disponibilizacao)) {
				throw new Exception("A data de disponibilização informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$atividade_teleeducacao->id = $codigo_identificacao;
			$atividade_teleeducacao->dtdispo = $data_disponibilizacao;
			$atividade_teleeducacao->cargah = $carga_horaria;
			$atividade_teleeducacao->tipo = $tipo_atividade;
			$atividade_teleeducacao->decs = $tema_codigo_decs;

			array_push($this->atividades_teleeducacao, $atividade_teleeducacao);
		}

		/**
		* Adiciona as participações em atividades de tele-educação
		* Observação: deve-se antes regitrar a atividade de tele-educação, veja {@link #addAtividade(String, String, String, TipoAtividade, String) addAtividade} method.
		* @param string $codigo_identificacao		Código único utilizado pelo núcleo para identificar atividade
		* @param string $data_da_participacao		Data/hora da participação no formato dd/MM/yyyy HH:MM:SS
		* @param string $cpf_participante		CPF do participante da atividade
		* @param string $especialidade_participante		Código CBO da ocupação do participante no momento da participação da atividade
		* @param string $estabelecimento_telessaude_participante		Código CNES do estabelecimento de saúde no qual o participante atua no momento da participação da atividade
		* @param string $equipe_participante		Código INE da equipe de saúde na qual o participante faz parte
		* @param GrauSatisfacao $grau_satisfacao		Grau de satisfação do participante quanto a atividade
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addParticipacaoAtividade($codigo_identificacao, $data_da_participacao, $cpf_participante, $especialidade_participante, $estabelecimento_telessaude_participante, $equipe_participante, $grau_satisfacao) {
			$participacao_teleeducacao = new stdClass();

			if (empty($this->atividades_teleeducacao)) {
				throw new Exception("Deve existir ao menos uma atividade registrada para o código de identificação fornecido.");
			}

			if (Integra::isBlankOrNull($codigo_identificacao)) {
				throw new Exception("Código de identificação da atividade é obrigatório.");
			}

			if (!Integra::validateDate($data_da_participacao)) {
				throw new Exception("A data de participação informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$participacao_teleeducacao->dtparti = $data_da_participacao;
			$participacao_teleeducacao->cpf = $cpf_participante;
			$participacao_teleeducacao->cbo = $especialidade_participante;
			$participacao_teleeducacao->cnes = $estabelecimento_telessaude_participante;
			if (!Integra::isBlankOrNull($equipe_participante)) {
				$participacao_teleeducacao->ine = $equipe_participante;
			}
			$participacao_teleeducacao->satisf = $grau_satisfacao;

			$atividade_teleeducacao = $this->findAtividadeInListByCodigoIdentificacao($codigo_identificacao);
			if (!isset($atividade_teleeducacao->participacoes_teleeducacao))
				$atividade_teleeducacao->participacoes_teleeducacao = array();
			array_push($atividade_teleeducacao->participacoes_teleeducacao, $participacao_teleeducacao);
		}
	}

	/**
	* Classe responsável por armazenar os dados de objetos de aprendizagem de teleeducação e seus respectivos acessos
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TeleeducacaoObjetoAprendizagem {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $objetos_aprendizagem = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adiciona os objetos de aprendizagem disponibilizados.
		* São considerados objetos de aprendizagem as ofertas de tele-educação  disponibilizadas de forma assíncronas em documento texto
	 	* ou audiovisual  para acesso de profissional de saúde (vide nota técnica 50/2015 DEGES/SGTES/MS
		*
		* @param string $codigo_identificacao		Código único utilizado pelo núcleo para identificar o objeto de aprendizagem
		* @param string $data_disponibilizacao		Data/hora em que o objeto de aprendizagem foi disponibilizado no formato d/MM/yyyy HH:mm:ss
		* @param boolean $disponibilizado_plataforma_telessaude		Se disponibilizado na plataforma de telessaúde do próprio núcleo
		* @param boolean $disponibilizado_ares		Se disponibilizado Biblioteca Virtual, Cletâne Telessaúde no ARES/UNA-SUS
		* @param boolean $disponibilizado_avasus		Se disponibilizado no AVA-SUS - Ambiente Virtual de Aprendizagem do Sistema Único de Saúde (SUS),
		* @param boolean $disponibilizado_redes_sociais		Se disponibilizado em alguma rede social
		* @param boolean $disponibilizado_outros		Se disponibilizado em outro repositório
		* @param TipoObjetoAprendizagem $tipo_objeto		Classificação do objeto de aprendizagem
		* @param string $tema_codigo_decs		Código da classificação do Descritores em Ciências da Saude (DeCS) da BIREME
		* @param string $url		Endereço de rede para acesso ao recurso quanto este for público, não necessita de credencias para acesso.
		* @param int $numero_acesso		Número de Acessos
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addObjetoAprendizagem($codigo_identificacao, $data_disponibilizacao, $disponibilizado_plataforma_telessaude, $disponibilizado_ares, $disponibilizado_avasus, $disponibilizado_redes_sociais, $disponibilizado_outros, $tipo_objeto, $tema_codigo_decs, $url, $numero_acesso) {
			$objeto_aprendizagem = new stdClass();

			if (Integra::isBlankOrNull($codigo_identificacao)) {
				throw new Exception("Código de identificação da atividade é obrigatório.");
			}

			if (!Integra::validateDate($data_disponibilizacao)) {
				throw new Exception("A data de disponibilização informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$objeto_aprendizagem->id = $codigo_identificacao;
			$objeto_aprendizagem->dtdispo = $data_disponibilizacao;
			$objeto_aprendizagem->dplataf = $disponibilizado_plataforma_telessaude ? "1" : "0";
			$objeto_aprendizagem->dares = $disponibilizado_ares ? "1" : "0";
			$objeto_aprendizagem->davasus = $disponibilizado_avasus ? "1" : "0";
			$objeto_aprendizagem->drsociais = $disponibilizado_redes_sociais ? "1" : "0";
			$objeto_aprendizagem->doutros = $disponibilizado_outros ? "1" : "0";
			$objeto_aprendizagem->tipo = $tipo_objeto;
			$objeto_aprendizagem->decs = $tema_codigo_decs;

			if (!Integra::isBlankOrNull($url)) {
				$objeto_aprendizagem->url = $url;
			}

			$objeto_aprendizagem->num = $numero_acesso;

			array_push($this->objetos_aprendizagem, $objeto_aprendizagem);
		}
	}

	/**
	* Classe responsável por armazenar os cursos oferecidos por meio da Tele-educação
	* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
	* @author Allyson Barros
	*/
	class TeleeducacaoCurso {
		public $codigo_nucleo = "";
		public $mes_referencia = "";
		public $cursos_teleeducacao = array();

		/**
		* Construtor da classe
		* @param string $codigo_nucleo		Código CNES de identifiação do núcleo cadastrado no SMART.
		* @param string $mes_referencia		Mês de referência para os indicadores informados.
		*/
		public function __construct($codigo_nucleo, $mes_referencia) {
			if (Integra::isBlankOrNull($codigo_nucleo)) {
				throw new Exception("Código do núcleo é obrigatório.");
			}

			$this->codigo_nucleo = $codigo_nucleo;
			$this->mes_referencia = Integra::validateDataReferencia($mes_referencia);
		}

		/**
		* Adiciona/atualiza o curso oferecido pela tele-educação
		* O SMART considera uma curso único pela chave  (identificacaoCurso e dataInicio)
		*
		* @param string $identificacao_curso		Código único utilizado pelo núcleo para identificar a disponibilização do curso
		* @param string $data_inicio		Data/hora no qual o curso foi disponibilizado formato d/MM/yyyy HH:mm:ss
		* @param string $data_fim		(opcional) Data/hora no qual o curso foi encerrado formato d/MM/yyyy HH:mm:ss
		* @param string $vagas_ofertadas		Quantidade de vagas ofertas
		* @param string $tema		Código da classificação do Descritores em Ciências da Saude (DeCS) da BIREME. Consultar lista de DeCS dispnonível no SMART através no menu "Cadastros Gerais > deSc BIREME - Descritores".
		* @param string $carga_horaria		Duração do curso em minutos
		* @param array $lista_cpf_matriculados	(opcional) Lista de CPFs dos alunos matriculados. Quando encerrar o período de matriculas do curso, deve-se enviar novamente o curso com a relação dos alunos matriculados.
		* @param array $lista_cpf_formados		(opcional) Lista de CPFs dos alunos formados. Quando o curso tiver sido encerrado, deve-se enviar novamente o curso com a relação dos alunos formado.
		* @param array $lista_cpf_evadidos		(opcional) Lista de CPFs dos alunos evadidos. Quando o curso tiver sido encerrado, deve-se enviar novamente o curso com a relação dos alunos evadidos.
		* @param array $lista_cpf_reprovados	(opcional) Lista de CPFs dos alunos reprovados. Quando o curso tiver sido encerrado, deve-se enviar novamente o curso com a relação dos alunos reprovados.
		* @since 2.0 Adicionado na versão 2.0 do Serviço REST do SMART (lançado em meados de fevereiro de 2016).
		*/
		public function addCurso($identificacao_curso, $data_inicio, $data_fim, $vagas_ofertadas, $tema, $carga_horaria, $lista_cpf_matriculados, $lista_cpf_formados, $lista_cpf_evadidos, $lista_cpf_reprovados) {
			$curso = new stdClass();

			if (Integra::isBlankOrNull($identificacao_curso)) {
				throw new Exception("Código de identificação do curso é obrigatório.");
			}

			if (!Integra::validateDate($data_inicio)) {
				throw new Exception("A data de início do curso informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			if (!Integra::isBlankOrNull($data_fim) and !Integra::validateDate($data_fim)) {
				throw new Exception("A data de encerramento do curso informada não está no formato dd/MM/yyyy HH:mm:ss.");
			}

			$curso->id = $identificacao_curso;
			$curso->dtini = $data_inicio;
			$curso->dtfim = $data_fim;
			$curso->vagas = $vagas_ofertadas;
			$curso->decs = $tema;
			$curso->cargah = $carga_horaria;

			if (!empty($lista_cpf_matriculados)) {
				$curso->cpfs_matri = $lista_cpf_matriculados;
			}
			if (!empty($lista_cpf_formados)) {
				$curso->cpfs_forma = $lista_cpf_formados;
			}
			if (!empty($lista_cpf_evadidos)) {
				$curso->cpfs_evadi = $lista_cpf_evadidos;
			}
			if (!empty($lista_cpf_reprovados)) {
				$curso->cpfs_repro = $lista_cpf_reprovados;
			}

			array_push($this->cursos_teleeducacao, $curso);
		}
	}
?>
