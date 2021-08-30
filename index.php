<header>
<style>
.block
{
    border: 4px double black;
    width: 300px;
    
    padding: 15px;
    margin:5px;
    text-align:center ;
    
     float: left;
}

.infoblock{
  display: inline-block;
  border: 4px  double black;
}

</style>

</header>
<table border=0>
<tr><td>
    <div class="block">
      <form action = "get.php" method="POST">
      <b>перечень палат, в которых дежурит выбранная медсестра </b><p>
      <?php
        require_once __DIR__ . "/vendor/autoload.php";
         echo "<select name='nurse' >";

         $collection = (new MongoDB\Client)->lb2var3->nurse; 
    
         $cursor = $collection->find();
     
         foreach ($cursor as $document)
        {    
        
                 echo "<option value=".$document['id_nurse'].">".$document['name']."</option>";
        }
     
         echo "</select>"."<br>";

      ?>

      <input type="Submit" name=button1 value=" Sumbit "><p>
      </form>
    </div>
</td></tr>

<tr><td>
    <div class="block">

        <form action = "get.php" method="POST">
        <b>медсестры, дежурившие в указанном отделении</b><p>
        отделениe: <select name="department">

          <option value="dep №1">dep №1</option>
          <option value="dep №2">dep №2</option>
          <option value="dep №3">dep №3</option>
      </select>
        <input type="Submit" name=button2 value=" Sumbit "><p>
        </form>
    </div>
</td></tr>

<tr><td>
    <div class="block">
        <form action = "get.php" method="POST">
        <b>всех дежурствах (в любых палатах) в указанную смену в указанном отделении.</b></p>
        отделениe: <select name="department">

        <option value="dep №1">dep №1</option>
        <option value="dep №2">dep №2</option>
        <option value="dep №3">dep №3</option>
        </select>

        сменa: <select name="shift">

        <option value="first">first</option>
        <option value="second">second</option>
        <option value="third">third</option>
        </select>


        <input type="Submit" name=button3 value=" Sumbit "><p>

        </form>
    </div>
</td></tr>
</table>


<div class="infoblock" >
<script>

document.write(localStorage.getItem("savedText"));

</script>
<div>

