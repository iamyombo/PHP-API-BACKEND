<?php
  class Contact {
    // Database Parameters
    private $conn;
    private $table = 'contacts';

    // Contact Class Properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $name;
    public $postcode;
    public $company_id;
    public $ContactID;
    
    //public $company_location;
    // public $created_at;
   

    // Constructor with Database Init.
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Method
    // GET ALL ACTIVE LIST : To return all contact list.

    public function list() {
      // Display ALL Contacts 
      // LEFT Join with Company Names and Postcode (as Location)
     

      $query ="SELECT a.*, a.id as ContactID, b.*
      FROM contacts a
      LEFT JOIN companies b
      ON a.company_id = b.id where a.is_deleted = 0 
      ORDER BY a.id ASC";

      // Prepare statement wit the query
      $stmt = $this->conn->prepare($query);

      // Execute query to return data to statement variable.
      $stmt->execute();

      return $stmt;
    }


    // Get Method : Display Single Contact
    // GET EXISTING CONTACT : To verify if Contact exist in the List
    // For verification before deletion.

    public function check() {

        // Display SINGLE Contact by ID
        $id = $_GET['id'];

        $query ="SELECT a.*, a.id as ContactID, b.*
        FROM contacts a
        LEFT JOIN companies b
        ON a.company_id = b.id where a.is_deleted = 0 and a.id = '{$id}'";
          
        // Prepare statement wit the query
        $stmt = $this->conn->prepare($query);
  
        // Execute query to return data to statement variable.
        $stmt->execute();
  
        return $stmt;

      }


    // PUT Method (SOFT DELETE)
    // Using the additional field "is_deleted"
    // On Soft Delete set the value of the "is_deleted = 1" as moved to Archive status

    public function delete() {

        $id = $_GET['id'];
        // Create query
        $query = 'UPDATE ' . $this->table . '
                              SET contacts.is_deleted = 1
                              WHERE contacts.id = ' .  $id . '';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    

    // PUT Method (RESTORE CONTACT FROM DELETE)
    // Using the additional field "is_deleted"
    // On Restored, set the value of "is_deleted = 0" as moved back to Active Contact List.

  public function restore() {

     $id = $_GET['id'];
     // Create query
     $query = 'UPDATE ' . $this->table . '
                           SET contacts.is_deleted = 0
                           WHERE contacts.id = ' .  $id . '';

     // Prepare statement
     $stmt = $this->conn->prepare($query);

     // Execute query
     if($stmt->execute()) {
       return true;
     }

     // Print error if something goes wrong
     printf("Error: %s.\n", $stmt->error);

     return false;

    }

    // GET Method (LIST CONTACT BY LOCATION)
    // List based on the Company Location

    public function location() {

        $postcode = strval($_GET['postcode']);

        $query ="SELECT a.*, a.id as ContactID, b.*
        FROM contacts a
        LEFT JOIN companies b
        ON a.company_id = b.id
        where b.postcode = '{$postcode} '" ;
        

        // Prepare statement wit the query
        $stmt = $this->conn->prepare($query);
  
        // Execute query to return data to statement variable.
        $stmt->execute();
  
        return $stmt;


    }

    // POST Method
    // To add new contact to the list
    // Id Field of the Contacts Table has been set to Auto Increment.
    
    public function newcontact() {

      //Insert query
      $query = 'INSERT INTO ' . $this->table . ' SET 
      firstname = :firstname, 
      lastname = :lastname, 
      email = :email, 
      company_id = :company_id';

      $stmt = $this->conn->prepare($query); //Query Statement.


      // Data Post & Binding
      $stmt->bindParam(':firstname', $this->firstname);
      $stmt->bindParam(':lastname', $this->lastname);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':company_id', $this->company_id );

      //Execute Insert Query
      if($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }



    // PUT Method
    // To update existing contact in the list
    
    public function editcontact() {


      $id = $_GET['id'];

      //Update query
      $query = "UPDATE contacts  SET 
      firstname = :firstname, 
      lastname = :lastname, 
      email = :email, 
      company_id = :company_id
      WHERE id =  '{$id}'";

      // WHERE id = :id';

      $stmt = $this->conn->prepare($query); //Query Statement.


     
      // Data Post & Binding
      //$stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':firstname', $this->firstname);
      $stmt->bindParam(':lastname', $this->lastname);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':company_id', $this->company_id );


      //Execute Insert Query
      if($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }


    
    // Get Method : Checking to verify if contact is already deleted.
    public function checkrestore() {

      // Check Deleted SINGLE Contact by ID
      $id = $_GET['id'];

      $query ="SELECT a.*, a.id as ContactID, b.*
      FROM contacts a
      LEFT JOIN companies b
      ON a.company_id = b.id where a.is_deleted = 1 and a.id = '{$id}'";
        
      //$query ="select * from contacts where is_deleted = 0 and id = '{$id}'";

      // Prepare statement wit the query
      $stmt = $this->conn->prepare($query);

      // Execute query to return data to statement variable.
      $stmt->execute();

      return $stmt;

    }

   
  }
