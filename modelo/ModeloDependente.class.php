<?php

    /**
     * Classe que realiza operações no banco
     * de dados envolvendo o dependente.
     *
     * @author Rafael de Paula - <rafael@bentonet.com.br>
     * @version 1.0.0 - 2015-08-27
     *
    **/
    class ModeloDependente extends Modelo{

        /**
         * Método utilizado para retornar o objeto DTO
         * do dependente requisitado
         *
         * @param Integer $cdnDependente - código numérico do dependente
         * @return Object - objeto DTO do dependente
         *
        **/
        public function getDependente($cdnDependente){
            return $this->getRegistro('dependente', 'cdnDependente', $cdnDependente);
        }

        /**
         * Método utilizado para preencher o DTO do dependente para cadastro.
         *
         * @param Integer $cdnResponsavel - código numérico do responsável
         * @param Boolean $indParceria - dependência é a partir de uma parceria
         * @return Array - DTO(0) e mensagem de erro(1)
         *
        **/
        public function dependentePreparaDTO($cdnResponsavel, $indParceria){
            $mesErro = '';
            $dtoDependente = new DTODependente();
            $dtoDependente->setCdnResponsavel($cdnResponsavel);
            $dtoDependente->setIndParceria($indParceria);

            if(!isset($_POST['cdnPaciente'])){
                $mesErro = 'Informe o paciente.';
    			return array($dtoDependente, $mesErro);
            }

            if(!$this->checaExiste('paciente', 'cdnPaciente', $_POST['cdnPaciente'])){
                $mesErro = 'Informe um paciente válido.';
                return array($dtoDependente, $mesErro);
            }

            $dtoDependente->setCdnPaciente($_POST['cdnPaciente']);

            return array($dtoDependente, $mesErro);

        }

        /**
         * Método utilizado para registrar o dependente
         * no banco de dados
         *
         * @param Object $dtoDependente - objeto DTO do dependente
         * @return Boolean - true se sucesso, false se não
         *
        **/
        public function dependenteCadastrarFim(DTODependente $dtoDependente){

                $dadosFinais = $dtoDependente->getArrayBanco();
                return $this->inserir('dependente', $dadosFinais);

        }
    }
