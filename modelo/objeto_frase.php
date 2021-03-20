<?php
class objeto_frase{
    private $id_frase;
    private $frase;
    private $autor_frase;

    /**
     * @return mixed
     */
    public function getIdFrase()
    {
        return $this->id_frase;
    }

    /**
     * @param mixed $id_frase
     */
    public function setIdFrase($id_frase)
    {
        $this->id_frase = $id_frase;
    }

    /**
     * @return mixed
     */
    public function getFrase()
    {
        return $this->frase;
    }

    /**
     * @param mixed $frase
     */
    public function setFrase($frase)
    {
        $this->frase = $frase;
    }

    /**
     * @return mixed
     */
    public function getAutorFrase()
    {
        return $this->autor_frase;
    }

    /**
     * @param mixed $autor_frase
     */
    public function setAutorFrase($autor_frase)
    {
        $this->autor_frase = $autor_frase;
    }

}
?>