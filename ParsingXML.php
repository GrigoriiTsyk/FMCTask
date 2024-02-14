<?php

class ParsingXML {
    private $content, $conn;
    public function parse (){
        $reader = (new XMLReader());
        $reader->XML($this->content);

        $data = array();

        $findID = "";

        while ($reader->read()) {
            if($reader->nodeType == XMLReader::ELEMENT){
                if($reader->localName == "Valute"){
                    $data[] = $reader->getAttribute("ID");
                }
            }
            if($reader->nodeType == XMLReader::TEXT) {
                $data[] = $reader->value;
            }

            if(count($data) == 7) {
                $findID = "SELECT * FROM valute WHERE id LIKE '" . $data[0] . "';";

                $stmt = $this->conn->query($findID);
                $answer = $stmt->fetch();

                if($answer == "") {
                    $temp = explode(",", $data[5]);

                    $data[5] = $temp[0] . "." . $temp[1];
                    
                    $temp = explode(",", $data[6]);

                    $data[6] = $temp[0] . "." . $temp[1];

                    $sql = "INSERT INTO valute(id, numcode, charcode, nominal, name, value, vunitrate)
                            VALUES('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', " 
                            . $data[3] . ", '" . $data[4] . "', " . $data[5] . ", "
                            . $data[6] . ");";

                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute();
                    
                    $data = array();
                }
            }
        }

        $reader->close();
    }

    public function __construct($content, $conn)
    {
        $this->content = $content;
        $this->conn = $conn;   
    }
}
