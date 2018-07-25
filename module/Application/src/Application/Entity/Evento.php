<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use \Doctrine\Common\Collections;

/**
 * Evento
 *
 * @ORM\Table(name="evento", indexes={@ORM\Index(name="fk_evento_usuario1_idx", columns={"usuario_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\EventoRepository")
 */
class Evento
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="nome", type="string", length=200, nullable=true)
     */
    private $nome;

    /**
     *
     * @var string @ORM\Column(name="sigla", type="string", length=15, nullable=true)
     */
    private $sigla;

    /**
     *
     * @var integer @ORM\Column(name="ano", type="integer", nullable=true)
     */
    private $ano;

    /**
     *
     * @var string @ORM\Column(name="numero_edicao", type="string", length=10, nullable=true)
     */
    private $numeroEdicao;

    /**
     *
     * @var \DateTime @ORM\Column(name="data_final", type="date", nullable=true)
     */
    private $dataFinal;

    /**
     *
     * @var \DateTime @ORM\Column(name="data_inicial", type="date", nullable=true)
     */
    private $dataInicial;

    /**
     *
     * @var Usuario @ORM\ManyToOne(targetEntity="Usuario")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     *      })
     */
    private $usuario;

    /**
     * Collection com todas as atividaes do evento
     * @ORM\OneToMany(targetEntity="Application\Entity\Atividade", mappedBy="evento")
     */
    private $atividades;

    public $verbose_name = 'Evento';
    public $verbose_name_plural = 'Eventos';

    public function __construct(array $options = array())
    {
        $this->atividades = new Collections\ArrayCollection();
        (new ClassMethods())->hydrate($options, $this);
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }

    public function dataForm()
    {
        $data = (new ClassMethods())->extract($this);

        /** @var $data_inicial \DateTime */
        /** @var $data_final \DateTime */

        $data_inicial = $data['data_inicial'];
        $data_final = $data['data_final'];

        $data['data_final'] = $data_final->format('d/m/Y');
        $data['data_inicial'] = $data_inicial->format('d/m/Y');
        
        return $data;
    }

    public function __toString()
    {
        return $this->getNome() . ' - Edição: ' . $this->getNumeroEdicao() . ' - Ano: ' . $this->getAno();
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     *
     * @param string $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     *
     * @return integer
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     *
     * @param integer $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    /**
     *
     * @return string
     */
    public function getNumeroEdicao()
    {
        return $this->numeroEdicao;
    }

    /**
     *
     * @param string $numeroEdicao
     */
    public function setNumeroEdicao($numeroEdicao)
    {
        $this->numeroEdicao = $numeroEdicao;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     *
     * @param \DateTime $dataFinal
     */
    public function setDataFinal($dataFinal)
    {
        $this->dataFinal = $dataFinal;
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     *
     * @param \DateTime $dataInicial
     */
    public function setDataInicial($dataInicial)
    {
        $this->dataInicial = $dataInicial;
    }


    /**
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     *
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     *
     * @return mixed
     */
    public function getAtividades()
    {
        return $this->atividades;
    }

    /**
     *
     * @param mixed $atividades
     */
    public function setAtividades($atividades)
    {
        $this->atividades = $atividades;
    }

    public function getTiposDeAtividades()
    {
        $tipos = array();
        /** @var  $atividade Atividade */
        foreach ($this->getAtividades() as $atividade) {
            
            $tipos[$atividade->getTipoAtividade()->getId()] = $atividade->getTipoAtividade();
        }
        
        return $tipos;
    }

    public function getPeriodo(){
        return $this->getDataFormatada($this->dataInicial, $this->dataFinal);
    }

    public function getDataFormatada(\DateTime $data_inicio, \DateTime $data_fim)
    {

        // se a data Ã© extatamente igual
        if ($data_inicio->format('d/m/y') == $data_fim->format('d/m/y')) {
            return $data_inicio->format('d') . ' de ' . $this->getMesExtenso($data_inicio->format('m')) . ' de ' . $data_inicio->format('Y');
        }

        // se o ano e mês são iguais e o dia não
        if ($data_inicio->format('m/y') == $data_fim->format('m/y')) {
            return $data_inicio->format('d') . ' a ' . $data_fim->format('d') . ' de ' . $this->getMesExtenso($data_inicio->format('m')) . ' de ' . $data_inicio->format('Y');
        }

        // se o ano sÃ£o iguais mas mes e dia nÃ£o diferentes
        if ($data_inicio->format('y') == $data_fim->format('y')) {
            return $data_inicio->format('d') . ' de ' . $this->getMesExtenso($data_inicio->format('m')) . ' a ' . $data_fim->format('d') . ' de ' . $this->getMesExtenso($data_fim->format('m')) . ' de ' . $data_fim->format('Y');
        }

        return $data_inicio->format('d') . ' de ' . $this->getMesExtenso($data_inicio->format('m')) . ' de ' . $data_inicio->format('Y') . ' a ' . $data_fim->format('d') . ' de ' . $this->getMesExtenso($data_fim->format('m')) . ' de ' . $data_fim->format('Y');
    }

    public function getMesExtenso($mes_numero)
    {
        $mes = null;

        switch ($mes_numero) {
            case "01":
                $mes = "janeiro";
                break;
            case "02":
                $mes = "fevereiro";
                break;
            case "03":
                $mes = "março";
                break;
            case "04":
                $mes = "abril";
                break;
            case "05":
                $mes = "maio";
                break;
            case "06":
                $mes = "junho";
                break;
            case "07":
                $mes = "julho";
                break;
            case "08":
                $mes = "agosto";
                break;
            case "09":
                $mes = "setembro";
                break;
            case "10":
                $mes = "outubro";
                break;
            case "11":
                $mes = "novembro";
                break;
            case "12":
                $mes = "dezembro";
                break;
        }

        return $mes;
    }

    public  function convert_number_to_words($number) {

        $hyphen      = '-';
        $conjunction = ' e ';
        $separator   = ', ';
        $negative    = 'menos ';
        $decimal     = ' ponto ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'um',
            2                   => 'dois',
            3                   => 'três',
            4                   => 'quatro',
            5                   => 'cinco',
            6                   => 'seis',
            7                   => 'sete',
            8                   => 'oito',
            9                   => 'nove',
            10                  => 'dez',
            11                  => 'onze',
            12                  => 'doze',
            13                  => 'treze',
            14                  => 'quatorze',
            15                  => 'quinze',
            16                  => 'dezesseis',
            17                  => 'dezessete',
            18                  => 'dezoito',
            19                  => 'dezenove',
            20                  => 'vinte',
            30                  => 'trinta',
            40                  => 'quarenta',
            50                  => 'cinquenta',
            60                  => 'sessenta',
            70                  => 'setenta',
            80                  => 'oitenta',
            90                  => 'noventa',
            100                 => 'cento',
            200                 => 'duzentos',
            300                 => 'trezentos',
            400                 => 'quatrocentos',
            500                 => 'quinhentos',
            600                 => 'seiscentos',
            700                 => 'setecentos',
            800                 => 'oitocentos',
            900                 => 'novecentos',
            1000                => 'mil',
            1000000             => array('milhão', 'milhões'),
            1000000000          => array('bilhão', 'bilhões'),
            1000000000000       => array('trilhão', 'trilhões'),
            1000000000000000    => array('quatrilhão', 'quatrilhões'),
            1000000000000000000 => array('quinquilhão', 'quinquilhões')
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $conjunction . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = floor($number / 100)*100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                if ($baseUnit == 1000) {
                    $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[1000];
                } elseif ($numBaseUnits == 1) {
                    $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
                } else {
                    $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
                }
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

}

