<?php
   
        require_once 'MasterPage.php';
        if(isset($_REQUEST['RConsultor'])){
        $Rconsultor = $_REQUEST['RConsultor'];
        require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
//        $objPHPExcel = new PHPExcel();
        
            $queryGeneral= "SELECT A.ruc_sunat, A.nombre,C.TRABAJADORES_SUNAT,f_lineas,f_speedy, f_ingreso_atis,
                            m_facturacion,m_lineas,m_bam,unired,infointernet,ip_vpn,ip_adsl,internet_negocios,
                            otros_avanzados,rdsi,troncal,central,f_facturacion_isis
                            FROM dbo.CLIENTES_NEGOCIOS_201701 A RIGHT JOIN CLIENTE C 
                            ON C.RUC= A.RUC_SUNAT 
                            WHERE RUC = '$Rconsultor'";
            
            $queryGeneral2="select
                            case 
                                    when HOLDING is null then '-'
                                    when HOLDING = '' then '-'
                                    WHEN HOLDING IS NOT NULL THEN 'si'
                                    end as HOLDING,
                            case
                                    when trabajadores_sunat is null then '-'
                                    when trabajadores_sunat = '' then '-'
                                    when TRABAJADORES_SUNAT IS not null then TRABAJADORES_SUNAT	
                                    end as trabajadores_sunat
                            from cliente where RUC='$Rconsultor'";
            
            $querySUM="select sum(isnull(f_lineas,0))+ sum(isnull(f_speedy,0)) as total FROM dbo.CLIENTES_NEGOCIOS_201701 WHERE RUC_SUNAT='$Rconsultor'";
            
            $querySUM2="SELECT sum(isnull(unired,0))+ sum(isnull(infointernet,0))+sum(isnull(ip_vpn,0))+ sum(isnull(ip_adsl,0))+sum(isnull(internet_negocios,0))+
                        sum(isnull(otros_avanzados,0))+sum(isnull(rdsi,0))+ sum(isnull(troncal,0))+sum(isnull(central,0)) AS TOTAL FROM CLIENTES_NEGOCIOS_201701 WHERE RUC_SUNAT='$Rconsultor'";
            $querySUM3="SELECT sum(isnull(m_lineas,0))+ sum(isnull(m_bam,0)) AS TOTAL FROM CLIENTES_NEGOCIOS_201701 WHERE RUC_SUNAT='$Rconsultor'";
            
            $queryDatTot= "SELECT [Nro lineas fijas], speedy, facturacion,[Cargo fijo], [Cargo fijo moviles], [Facturacion movil], BAM, [Nro lineas moviles], [Paquete de datos],
                    [Internet negocios],unired,infointernet,[IP VPN],  [IP ADSL], rdsi, troncal, central,[otros avanzados], [Facturación ISIS] 
                    FROM clientes_negocios where RUC = '$Rconsultor'";
            //MOVILES
            $queryMoviles = "SELECT TIP_LIN,ID_CLIENTE,NOMBRE_CLIENTE,ANEXO,TELEFONO,FECHA_ALTA,
                            ESTADO_TELEFONO,[PLAN],VALOR_PLAN,MARCA_BOLSA,MARCA_DATOS,TIPO_PLAN_DATOS,MB_PLAN,EECC,CF_FACTURADO,
                            SUB_TOTAL_FACTURADO,CF_VOZ,CF_DAT,ADIC_MINS,ADIC_SMS,ADIC_DATOS,PAQ_SMS,MARCA 
                            FROM dbo.PLANTA_TM_201701n WHERE RUC_CLIENTE = '$Rconsultor'";
            //FIJA
            $queryFija= "SELECT ORIGEN,PERIODO,RUC,COD_CLIENTE,COD_CUENTA,INGRESO,COD_FACTURACION,NOMB_CLIENTE,SEGMENTO,DESC_CONCEPTO,PRODUCTO,
                              SUBTIP_INGRESO,GRUPO_DE_PROD,SEG_DEL_SISTEMA,TIPO_INGRESO FROM Fact_Fija WHERE RUC='".$Rconsultor."' AND ORIGEN in ('ATIS','CMS')";
            
            //LÍNEAS
            
            $queryLineas= "SELECT Cliente,Cuenta, NOMBRE_CLIENTE,isnull(RUC_CLIENTE,'No Registrado') NRO_RUC_CTE,NOMBRE_CLIENTE,isnull(RUC_CUENTA,'No Registrado') NRO_RUC_CTA,telefono,
				isnull(MACROSEGMENTO,'No Tiene') LINEA_Tipo_1,isnull(TIPO_LINEA_2,'No Tiene') LINEA_Tipo_2,isnull(TIPO_LINEA_2,'No Tiene') LINEA_Tipo_3,
				isnull(TD_TRIODUO,'No Tiene') PQT_Tipo, isnull(SPEEDY_Producto,'No Tiene') SPEEDY_Producto
				from DBO.PLANTA_NEGOCIOS_201701_DEPURADA  where SUNAT_RUC='".$Rconsultor."'";
            
            //AVANZADOS
            $queryAvanzado= "select cod_iden_prod,cod_ano,cod_mes,servi_cmi,tip_ser_cmi,cod_clie,cod_cod_fact,nomb_clie,num_ruc,des_prod,mon_oper_sole,velo_cmi_fin,velo_byts,[Línea de Negocio] as lnegocio,[Sublínea de negocio] as snegocio,
                            segmento,negocio from Fact_AVANZADA where num_ruc='".$Rconsultor."'";
            

            
            $RSDATTOT=sqlsrv_query($connect,$queryGeneral);
            $RSDATTOT2=sqlsrv_query($connect,$querySUM);
            $RSDATTOT3=sqlsrv_query($connect,$querySUM2);
            $RSDATTOT4=sqlsrv_query($connect,$querySUM3);
            $RSDATTOT5=sqlsrv_query($connect,$queryGeneral2);

            $RSDETALLEMOVILES = sqlsrv_query($connect,$queryMoviles);
            $RSDETALLEFIJA = sqlsrv_query($connect,$queryFija);
            $RSDETALLELINEA = sqlsrv_query($connect,$queryLineas);
            
            $RSDETALLEAVANZADO= sqlsrv_query($connect,$queryAvanzado);
    // Create new PHPExcel object
            
    $objPHPExcel = new PHPExcel();

        
    // Create a first sheet, representing sales data
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()
            ->setCellValue('A2', 'RUC')
            ->setCellValue('A3', 'CLIENTE')
            ->setCellValue('A4', 'POTENCIAL')
            ->setCellValue('A5', '# TRABAJADORES')
            ->setCellValue('A6', '# SEDES')
            ->setCellValue('A7', 'ES HOLDING')
            ->setCellValue('A10', 'FIJA TRADICIONAL')
            ->setCellValue('B10', 'TOTAL')
            ->setCellValue('C10', 'LINEAS')
            ->setCellValue('D10', 'SPEEDY')
            ->setCellValue('E10', 'CABLE')
            ->setCellValue('A11', '# PRODUCTOS')
            ->setCellValue('A12', 'CARGO RECURRENTE(S/.)')
            ->setCellValue('A14', 'MÓVIL')
            ->setCellValue('B14', 'TOTAL')
            ->setCellValue('C14', 'MÓVILES')
            ->setCellValue('D14', 'USB MÓVIL')
            ->setCellValue('A15', '# PRODUCTOS')
            ->setCellValue('A16', 'CARGO RECURRENTE(S/.)')
            ->setCellValue('A18', 'AVANZADOS FIJOS')
            ->setCellValue('A19', '#PRODUCTOS')
            ->setCellValue('A20', 'CARGO RECURRENTE(S/.)')
            ->setCellValue('C18', 'INTERNET NEGOCIOS')
            ->setCellValue('D18', 'INFOR INTERNET')
            ->setCellValue('E18', 'VPN')
            ->setCellValue('G18', 'CENTRAL')
            ->setCellValue('H18', 'SIPTRUNK')
            ->setCellValue('I18', 'PRIMARIO(RDSI)')
            ->setCellValue('J18', 'TRONCAL')
            ->setCellValue('L18', 'UNIRED')
            ->setCellValue('M18', 'OTROS*')
            ->setCellValue('A22', 'AVANZADOS IOT')
            ->setCellValue('B22', 'TOTAL')
            ->setCellValue('A23', '# PRODUCTOS')
            ->setCellValue('A24', 'CARGO RECURRENTE (S/.)')
            ->setCellValue('C22', 'GEO')
            ->setCellValue('D22', 'M2M')
            ->setCellValue('E22', 'FLOTA')
            ->setCellValue('G22', 'SG')
            ->setCellValue('H22', 'TS');
            
            
            

   while ($rowDatTot = sqlsrv_fetch_array($RSDATTOT)){     
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B2", $rowDatTot['ruc_sunat'])
                ->setCellValue("B3", $rowDatTot['nombre'])
                ->setCellValue("B5", $rowDatTot['TRABAJADORES_SUNAT'])
                ->setCellValue("B12", $rowDatTot['f_ingreso_atis'])
                ->setCellValue("C11", $rowDatTot['f_lineas'])
                ->setCellValue("D11", $rowDatTot['f_speedy'])
                ->setCellValue("B16", $rowDatTot['m_facturacion'])
                ->setCellValue("C15", $rowDatTot['m_lineas'])
                ->setCellValue("D15", $rowDatTot['m_bam'])
                ->setCellValue("B20", $rowDatTot['f_facturacion_isis'])
                ->setCellValue("C19", $rowDatTot['internet_negocios'])
                ->setCellValue("D19", $rowDatTot['infointernet'])
                ->setCellValue("E19", $rowDatTot['ip_vpn'])
                ->setCellValue("G19", $rowDatTot['central'])
                ->setCellValue("I19", $rowDatTot['rdsi'])
                ->setCellValue("J19", $rowDatTot['troncal'])
                ->setCellValue("L19", $rowDatTot['unired'])
                ->setCellValue("M19", $rowDatTot['otros_avanzados']);
   
        
        }
       
        while ($rowDatTot2 = sqlsrv_fetch_array($RSDATTOT2)){     
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B11",$rowDatTot2['total']);
                
        }
        while ($rowDatTot3 = sqlsrv_fetch_array($RSDATTOT3)){     
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B19",$rowDatTot3['TOTAL']);
                
        }
        while ($rowDatTot4 = sqlsrv_fetch_array($RSDATTOT4)){     
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B15",$rowDatTot4['TOTAL']);
                
        }
         while ($rowDatTot5 = sqlsrv_fetch_array($RSDATTOT5)){     
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("B5",$rowDatTot5['trabajadores_sunat'])
                ->setCellValue("B7",$rowDatTot5['HOLDING']);
                
        
        $VHolding=$rowDatTot5['HOLDING'];
        
        }
        
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A2:A7')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                             )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
         $objPHPExcel->getActiveSheet()
                    ->getStyle('A10:E10')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
          $objPHPExcel->getActiveSheet()
                    ->getStyle('A14:D14')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
          $objPHPExcel->getActiveSheet()
                    ->getStyle('G18:J18')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
          $objPHPExcel->getActiveSheet()
                    ->getStyle('A18:E18')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
            $objPHPExcel->getActiveSheet()
                                ->getStyle('L18:M18')
                                ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '20a1be')
                                        )
                                    )
                                )
                                ->getFont()->setBold(true)
                            ;
            $objPHPExcel->getActiveSheet()
                                ->getStyle('A22:E22')
                                ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '20a1be')
                                        )
                                    )
                                )
                                ->getFont()->setBold(true)
                            ;
            $objPHPExcel->getActiveSheet()
                                ->getStyle('G22:H22')
                                ->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '20a1be')
                                        )
                                    )
                                )
                                ->getFont()->setBold(true)
                            ;

        
    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Resumen del Cliente')->setShowGridlines(false);

    // Crear una nueva hoja en excel, despues de la default
    $objPHPExcel->createSheet();
//DETALLEMOVIL
        $admcellnum="2";
        $bdmcellnum="2";
        $cdmcellnum="2";
        $ddmcellnum="2";
        $edmcellnum="2";
        $fdmcellnum="2";
        $gdmcellnum="2";
        $hdmcellnum="2";
        $idmcellnum="2";
        $jdmcellnum="2";
        $kdmcellnum="2";
        $ldmcellnum="2";
        $mdmcellnum="2";
        $ndmcellnum="2";
        $odmcellnum="2";
        $pdmcellnum="2";
        $qdmcellnum="2";
        $rdmcellnum="2";
        $sdmcellnum="2";
        $tdmcellnum="2";
        $udmcellnum="2";
        $vdmcellnum="2";
        $xdmcellnum="2";
        
    // Add some data to the second sheet, resembling some different data types
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'TIP_LIN')
            ->setCellValue('B1', 'ID_CLIENTE')
            ->setCellValue('C1', 'NOMBRE_CLIENTE')
            ->setCellValue('D1', 'ANEXO')
            ->setCellValue('E1', 'TELEFONO')
            ->setCellValue('F1', 'FECHA_ALTA')
            ->setCellValue('G1', 'ESTADO_TELEFONO')
            ->setCellValue('H1', 'PLAN')
            ->setCellValue('I1', 'VALOR_PLAN')
            ->setCellValue('J1', 'MARCA_BOLSA')
            ->setCellValue('K1', 'MARCA_DATOS')
            ->setCellValue('L1', 'TIPO_PLAN_DATOS')
            ->setCellValue('M1', 'MB_PLAN')
            ->setCellValue('N1', 'EECC')
            ->setCellValue('O1', 'CF_FACTURADO')
            ->setCellValue('P1', 'SUB_TOTAL_FACTURADO')
            ->setCellValue('Q1', 'CF_VOZ')
            ->setCellValue('R1', 'CF_DAT')
            ->setCellValue('S1', 'ADIC_MINS')
            ->setCellValue('T1', 'ADIC_SMS')
            ->setCellValue('U1', 'ADIC_DATOS')
            ->setCellValue('V1', 'PAQ_SMS')
            ->setCellValue('X1', 'MARCA');
    
    while ($rowDETMOV = sqlsrv_fetch_array($RSDETALLEMOVILES)){     
        $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue("A".$admcellnum, $rowDETMOV['TIP_LIN'])
                ->setCellValue("B".$bdmcellnum, $rowDETMOV['ID_CLIENTE'])
                ->setCellValue("C".$cdmcellnum, $rowDETMOV['NOMBRE_CLIENTE'])
                ->setCellValue("D".$ddmcellnum, $rowDETMOV['ANEXO'])
                ->setCellValue("E".$edmcellnum, $rowDETMOV['TELEFONO'])
                ->setCellValue("F".$fdmcellnum, $rowDETMOV['FECHA_ALTA'])
                ->setCellValue("G".$gdmcellnum, $rowDETMOV['ESTADO_TELEFONO'])
                ->setCellValue("H".$hdmcellnum, $rowDETMOV['PLAN'])
                ->setCellValue("I".$idmcellnum, $rowDETMOV['VALOR_PLAN'])
                ->setCellValue("J".$jdmcellnum, $rowDETMOV['MARCA_BOLSA'])
                ->setCellValue("K".$jdmcellnum, $rowDETMOV['MARCA_DATOS'])
                ->setCellValue("L".$jdmcellnum, $rowDETMOV['TIPO_PLAN_DATOS'])
                ->setCellValue("M".$jdmcellnum, $rowDETMOV['MB_PLAN'])
                ->setCellValue("N".$kdmcellnum, $rowDETMOV['EECC'])
                ->setCellValue("O".$ldmcellnum, $rowDETMOV['CF_FACTURADO'])
                ->setCellValue("P".$mdmcellnum, $rowDETMOV['SUB_TOTAL_FACTURADO'])
                ->setCellValue("Q".$ndmcellnum, $rowDETMOV['CF_VOZ'])
                ->setCellValue("R".$odmcellnum, $rowDETMOV['CF_DAT'])
                ->setCellValue("S".$pdmcellnum, $rowDETMOV['ADIC_MINS'])
                ->setCellValue("T".$qdmcellnum, $rowDETMOV['ADIC_SMS'])
                ->setCellValue("U".$rdmcellnum, $rowDETMOV['ADIC_DATOS'])
                ->setCellValue("V".$sdmcellnum, $rowDETMOV['PAQ_SMS'])
                ->setCellValue("X".$tdmcellnum, $rowDETMOV['MARCA']);

                $admcellnum++;
                $bdmcellnum++;
                $cdmcellnum++;
                $ddmcellnum++;
                $edmcellnum++;
                $fdmcellnum++;
                $gdmcellnum++;
                $hdmcellnum++;
                $idmcellnum++;
                $jdmcellnum++;
                $kdmcellnum++;
                $ldmcellnum++;
                $mdmcellnum++;
                $ndmcellnum++;
                $odmcellnum++;
                $pdmcellnum++;
                $qdmcellnum++;
                $rdmcellnum++;
                $sdmcellnum++;
                $tdmcellnum++;
                
                

        } 
    // Rename 2nd sheet
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:X1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
    $objPHPExcel->getActiveSheet()->setTitle('Facturación Movil');
    
    
    //AQUI LA TERCERA HOJA DEL EXCEL

     $objPHPExcel->createSheet();
        
        $aafcellnum="2";
        $bafcellnum="2";
        $cafcellnum="2";
        $dafcellnum="2";
        $eafcellnum="2";
        $fafcellnum="2";
        $gafcellnum="2";
        $hafcellnum="2";
        $iafcellnum="2";
        $jafcellnum="2";
        $kafcellnum="2";
        $lafcellnum="2";
        $mafcellnum="2";
        $nafcellnum="2";
        $oafcellnum="2";
        $qafcellnum="2";
        $rafcellnum="2";
        $safcellnum="2";
        $tafcellnum="2";
        $uafcellnum="2";
        $vafcellnum="2";
        
         $objPHPExcel->setActiveSheetIndex(2);
         $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'ORIGEN')
            ->setCellValue('B1', 'PERIODO')
            ->setCellValue('C1', 'RUC')
            ->setCellValue('D1', 'COD_CLIENTE')
            ->setCellValue('E1', 'COD_CUENTA')
            ->setCellValue('F1', 'INGRESO')
            ->setCellValue('G1', 'COD_FACTURACION')
            ->setCellValue('H1', 'NOMB_CLIENTE')
            ->setCellValue('I1', 'SEGMENTO')
            ->setCellValue('J1', 'DESC_CONCEPTO')
            ->setCellValue('K1', 'PRODUCTO')
            ->setCellValue('L1', 'SUBTIP_INGRESO')
            ->setCellValue('M1', 'GRUPO_DE_PROD')
            ->setCellValue('N1', 'SEG_DEL_SISTEMA')
            ->setCellValue('O1', 'TIPO_INGRESO');
         
         
         
    while ($rowDETFIJA = sqlsrv_fetch_array($RSDETALLEFIJA)){     
        $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue("A".$aafcellnum, $rowDETFIJA['ORIGEN'])
                ->setCellValue("B".$bafcellnum, $rowDETFIJA['PERIODO'])
                ->setCellValue("C".$cafcellnum, $rowDETFIJA['RUC'])
                ->setCellValue("D".$dafcellnum, $rowDETFIJA['COD_CLIENTE'])
                ->setCellValue("E".$eafcellnum, $rowDETFIJA['COD_CUENTA'])
                ->setCellValue("F".$fafcellnum, $rowDETFIJA['INGRESO'])
                ->setCellValue("G".$gafcellnum, $rowDETFIJA['COD_FACTURACION'])
                ->setCellValue("H".$hafcellnum, $rowDETFIJA['NOMB_CLIENTE'])
                ->setCellValue("I".$iafcellnum, $rowDETFIJA['SEGMENTO'])
                ->setCellValue("J".$jafcellnum, $rowDETFIJA['DESC_CONCEPTO'])
                ->setCellValue("K".$kafcellnum, $rowDETFIJA['PRODUCTO'])
                ->setCellValue("L".$lafcellnum, $rowDETFIJA['SUBTIP_INGRESO'])
                ->setCellValue("M".$mafcellnum, $rowDETFIJA['GRUPO_DE_PROD'])
                ->setCellValue("N".$nafcellnum, $rowDETFIJA['SEG_DEL_SISTEMA'])
                ->setCellValue("O".$vafcellnum, $rowDETFIJA['TIPO_INGRESO']);

                $aafcellnum++;
                $bafcellnum++;
                $cafcellnum++;
                $dafcellnum++;
                $eafcellnum++;
                $fafcellnum++;
                $gafcellnum++;
                $hafcellnum++;
                $iafcellnum++;
                $jafcellnum++;
                $kafcellnum++;
                $lafcellnum++;
                $mafcellnum++;
                $nafcellnum++;
                $vafcellnum++;
        }      
         $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:O1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
        
    $objPHPExcel->getActiveSheet()->setTitle('Facturación Fija');
    
    //aqui la 4ta hoja (detFija)
    $objPHPExcel->createSheet();
        $al1cellnum="2";
        $bl1cellnum="2";
        $cl1cellnum="2";
        $dl1cellnum="2";
        $el1cellnum="2";
        $fl1cellnum="2";
        $gl1cellnum="2";
        $hl1cellnum="2";
        $il1cellnum="2";
        $jl1cellnum="2";
        $kl1cellnum="2";
        $ll1cellnum="2";
        
        $objPHPExcel->setActiveSheetIndex(3);
         $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'Cliente')
            ->setCellValue('B1', 'Cuenta')
            ->setCellValue('C1', 'NOMBRE_CLIENTE')
            ->setCellValue('D1', 'NRO_RUC_CTE')
            ->setCellValue('E1', 'NOMBRE_CLIENTE')
            ->setCellValue('F1', 'NRO_RUC_CTA')
            ->setCellValue('G1', 'telefono')
            ->setCellValue('H1', 'LINEA_Tipo_1')
            ->setCellValue('I1', 'LINEA_Tipo_2')
            ->setCellValue('J1', 'LINEA_Tipo_3')
            ->setCellValue('K1', 'PQT_Tipo')
            ->setCellValue('L1', 'SPEEDY_Producto');
        
        
       while ($rowdetLinea=sqlsrv_fetch_array($RSDETALLELINEA)){     
        $objPHPExcel->setActiveSheetIndex(3)
                ->setCellValue("A".$al1cellnum, $rowdetLinea['Cliente'])
                ->setCellValue("B".$bl1cellnum, $rowdetLinea['Cuenta'])
                ->setCellValue("C".$cl1cellnum, $rowdetLinea['NOMBRE_CLIENTE'])
                ->setCellValue("D".$dl1cellnum, $rowdetLinea['NRO_RUC_CTE'])
                ->setCellValue("E".$el1cellnum, $rowdetLinea['NOMBRE_CLIENTE'])
                ->setCellValue("F".$fl1cellnum, $rowdetLinea['NRO_RUC_CTA'])
                ->setCellValue("G".$gl1cellnum, $rowdetLinea['telefono'])
                ->setCellValue("H".$hl1cellnum, $rowdetLinea['LINEA_Tipo_1'])
                ->setCellValue("I".$il1cellnum, $rowdetLinea['LINEA_Tipo_2'])
                ->setCellValue("J".$jl1cellnum, $rowdetLinea['LINEA_Tipo_3'])
                ->setCellValue("K".$kl1cellnum, $rowdetLinea['PQT_Tipo'])
                ->setCellValue("L".$ll1cellnum, $rowdetLinea['SPEEDY_Producto'])
                ;
                
                $al1cellnum++;
                $bl1cellnum++;
                $cl1cellnum++;
                $dl1cellnum++;
                $el1cellnum++;
                $fl1cellnum++;
                $gl1cellnum++;
                $hl1cellnum++;
                $il1cellnum++;
                $jl1cellnum++;
                $kl1cellnum++;
                $ll1cellnum++;
                
        }
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:L1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
        
        
    $objPHPExcel->getActiveSheet()->setTitle('Tenencia Linea');
    
    
    //aqui la 5ta hoja (avanzada)
    $objPHPExcel->createSheet();
        $a1cellnum="2";
        $b1cellnum="2";
        $c1cellnum="2";
        $d1cellnum="2";
        $e1cellnum="2";
        $f1cellnum="2";
        $g1cellnum="2";
        $h1cellnum="2";
        $i1cellnum="2";
        $j1cellnum="2";
        $k1cellnum="2";
        $l1cellnum="2";
        $m1cellnum="2";
        $n1cellnum="2";
        $o1cellnum="2";
        $p1cellnum="2";
        $aCD1cellnum="2";
        
        
        $objPHPExcel->setActiveSheetIndex(4);
         $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'CD')
            ->setCellValue('B1', 'cod_ano')
            ->setCellValue('C1', 'cod_mes')
            ->setCellValue('D1', 'servi_cmi')
            ->setCellValue('E1', 'tip_ser_cmi')
            ->setCellValue('F1', 'cod_clie')
            ->setCellValue('G1', 'cod_cod_fact')
            ->setCellValue('H1', 'nomb_clie')
            ->setCellValue('I1', 'num_ruc')
            ->setCellValue('J1', 'des_prod')
            ->setCellValue('K1', 'Monto Operación')
            ->setCellValue('L1', 'velo_cmi_fin')
            ->setCellValue('M1', 'velo_byts')
            ->setCellValue('N1', 'línea de Negocio')
            ->setCellValue('O1', 'Sublínea de negocio')
            ->setCellValue('P1', 'segmento')
            ->setCellValue('Q1', 'negocio');
        
        
        while ($rowAvanzado=sqlsrv_fetch_array($RSDETALLEAVANZADO)){     
        $objPHPExcel->setActiveSheetIndex(4)
                ->setCellValue("A".$aCD1cellnum, $rowAvanzado['cod_iden_prod'])
                ->setCellValue("B".$a1cellnum, $rowAvanzado['cod_ano'])
                ->setCellValue("C".$b1cellnum, $rowAvanzado['cod_mes'])
                ->setCellValue("D".$c1cellnum, $rowAvanzado['servi_cmi'])
                ->setCellValue("E".$d1cellnum, $rowAvanzado['tip_ser_cmi'])
                ->setCellValue("F".$e1cellnum, $rowAvanzado['cod_clie'])
                ->setCellValue("G".$f1cellnum, $rowAvanzado['cod_cod_fact'])
                ->setCellValue("H".$g1cellnum, $rowAvanzado['nomb_clie'])
                ->setCellValue("I".$h1cellnum, $rowAvanzado['num_ruc'])
                ->setCellValue("J".$i1cellnum, $rowAvanzado['des_prod'])
                ->setCellValue("K".$j1cellnum, $rowAvanzado['mon_oper_sole'])
                ->setCellValue("L".$k1cellnum, $rowAvanzado['velo_cmi_fin'])
                ->setCellValue("M".$l1cellnum, $rowAvanzado['velo_byts'])
                ->setCellValue("N".$m1cellnum, $rowAvanzado['lnegocio'])
                ->setCellValue("O".$n1cellnum, $rowAvanzado['snegocio'])
                ->setCellValue("P".$o1cellnum, $rowAvanzado['segmento'])
                ->setCellValue("Q".$p1cellnum, $rowAvanzado['negocio']);
                
                $a1cellnum++;
                $b1cellnum++;
                $c1cellnum++;
                $d1cellnum++;
                $e1cellnum++;
                $f1cellnum++;
                $g1cellnum++;
                $h1cellnum++;
                $i1cellnum++;
                $j1cellnum++;
                $k1cellnum++;
                $l1cellnum++;
                $m1cellnum++;
                $n1cellnum++;
                $o1cellnum++;
                $p1cellnum++;
                $aCD1cellnum++;
        }
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:Q1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '20a1be')
                            )
                        )
                    )
                    ->getFont()->setBold(true)
                ;
        
        
    $objPHPExcel->getActiveSheet()->setTitle('Facturación Avanzada');
        
    //5ta hoja
//        $queryHolding= "SELECT RUC,RAZON_SOCIAL,HOLDING,SEGMENTO, SUB_SEGMENTO,CANAL,TIPO_CLIENTE, DEPARTAMENTO,
//        PROVINCIA, DISTRITO,GIRO_NEGOCIO,JEFE,EJECUTIVO_COMERCIAL,TERRITORIO,TIPO_ATENCION from dbo.CLIENTE where HOLDING='".$VHolding."' and HOLDING is not null";
//        $RSDETALLEHolding= sqlsrv_query($connect,$queryHolding);
//    
//    $objPHPExcel->createSheet();
//    
//        $a2cellnum="2";
//        $b2cellnum="2";
//        $c2cellnum="2";
//        $d2cellnum="2";
//        $e2cellnum="2";
//        $f2cellnum="2";
//        $g2cellnum="2";
//        $h2cellnum="2";
//        $i2cellnum="2";
//        $j2cellnum="2";
//        $k2cellnum="2";
//        $l2cellnum="2";
//        $m2cellnum="2";
//        $n2cellnum="2";
//        $o2cellnum="2";
//        
//        
//        $objPHPExcel->setActiveSheetIndex(4);
//         $objPHPExcel->getActiveSheet()
//            ->setCellValue('A1', 'RUC')
//            ->setCellValue('B1', 'RAZON SOCIAL')
//            ->setCellValue('C1', 'HOLDING')
//            ->setCellValue('D1', 'SEGMENTO')
//            ->setCellValue('E1', 'SUB SEGMENTO')
//            ->setCellValue('F1', 'CANAL')
//            ->setCellValue('G1', 'TIPO CLIENTE')
//            ->setCellValue('H1', 'DEPARTAMENTO')
//            ->setCellValue('I1', 'PROVINCIA')
//            ->setCellValue('J1', 'DISTRITO')
//            ->setCellValue('K1', 'GIRO NEGOCIO')
//            ->setCellValue('L1', 'JEFE')
//            ->setCellValue('M1', 'EJECUTIVO_COMERCIAL')
//            ->setCellValue('N1', 'TERRITORIO')
//            ->setCellValue('O1', 'TIPO ATENCION');
//        
//        
//     while ($rowHOLDING=sqlsrv_fetch_array($RSDETALLEHolding)){     
//        $objPHPExcel->setActiveSheetIndex(4)
//                ->setCellValue("A".$a2cellnum, $rowHOLDING['RUC'])
//                ->setCellValue("B".$b2cellnum, $rowHOLDING['RAZON_SOCIAL'])
//                ->setCellValue("C".$c2cellnum, $rowHOLDING['HOLDING'])
//                ->setCellValue("D".$d2cellnum, $rowHOLDING['SEGMENTO'])
//                ->setCellValue("E".$e2cellnum, $rowHOLDING['SUB_SEGMENTO'])
//                ->setCellValue("F".$f2cellnum, $rowHOLDING['CANAL'])
//                ->setCellValue("G".$g2cellnum, $rowHOLDING['TIPO_CLIENTE'])
//                ->setCellValue("H".$h2cellnum, $rowHOLDING['DEPARTAMENTO'])
//                ->setCellValue("I".$i2cellnum, $rowHOLDING['PROVINCIA'])
//                ->setCellValue("J".$j2cellnum, $rowHOLDING['DISTRITO'])
//                ->setCellValue("K".$k2cellnum, $rowHOLDING['GIRO_NEGOCIO'])
//                ->setCellValue("L".$l2cellnum, $rowHOLDING['JEFE'])
//                ->setCellValue("M".$m2cellnum, $rowHOLDING['EJECUTIVO_COMERCIAL'])
//                ->setCellValue("N".$n2cellnum, $rowHOLDING['TERRITORIO'])
//                ->setCellValue("O".$o2cellnum, $rowHOLDING['TIPO_ATENCION']);
//                
//                $a2cellnum++;
//                $b2cellnum++;
//                $c2cellnum++;
//                $d2cellnum++;
//                $e2cellnum++;
//                $f2cellnum++;
//                $g2cellnum++;
//                $h2cellnum++;
//                $i2cellnum++;
//                $j2cellnum++;
//                $k2cellnum++;
//                $l2cellnum++;
//                $m2cellnum++;
//                $n2cellnum++;
//                $o2cellnum++;
//                
//        }
//        $objPHPExcel->getActiveSheet()
//                    ->getStyle('A1:O1')
//                    ->applyFromArray(
//                        array(
//                            'fill' => array(
//                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                                'color' => array('rgb' => '20a1be')
//                            )
//                        )
//                    )
//                    ->getFont()->setBold(true)
//                ;
//        
//        
//    $objPHPExcel->getActiveSheet()->setTitle('Detalle HOLDING');
    

    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=Consultor-$Rconsultor.xlsx");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    ob_end_clean();
    $objWriter->save('php://output');
} ?>
