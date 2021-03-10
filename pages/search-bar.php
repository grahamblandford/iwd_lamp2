<?php

/*
    Title:       search-bar.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Handles login
    Author:      G. Blandford,  Group 9, INFO-5094-01-21W
    Date:        March 8th, 2021 (March 8th, 2021) 
*/

function getSearch($fvalue)
{ ?>
    <div id="container-search" class="container-fluid">
        <table class="table table-light">
            <tbody id="tbody-search">
                <tr>
                    <div class="input-group">
                        <td>
                            <label for="text-search" style="max-width: 60px">Search</label>
                            <input type="text" id="text-search" style="width: 200px" class="form-inline" name="text-search" value="<?php echo $fvalue ?>">
                            <div id="div-search-buttons">
                                <input type="submit" id="btn-search" class="btn btn-primary btn-crud" name="btn-search" value="Search">
                                <input type="submit" class="btn btn-secondary btn-crud" name="btn-search-clear" value="Clear" onclick="(function(){ document.getElementById('text-search').value=''; })()">
                            </div>
                        </td>
                    </div>
                </tr>
            </tbody>
        </table>
    </div>
<?php
}
?>