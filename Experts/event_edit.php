<form name="event" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>?month=<?php echo $month;?>&day=<?php echo $day;?>&year=<?php echo $year;?>&event_id=<?php echo $row["event_id"];?>&v=true&edit=true">
    <table width="400px">
        <?php
            $start_date = date("m/d/Y", strtotime($row["start_date"]));
            $end_date = date("m/d/Y", strtotime($row["end_date"]));
        ?>
        <tr>
            <td width="150px">Title</td>
            <td><input type="text" name="txtTitle" value='<?php echo $row['title']; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorTitle;}?></td>
        </tr>
        <tr>
            <td width="150px">Location:</td>
            <td><input type="text" name="txtLocation" value='<?php echo $row['location']; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorLocation;}?></td>
        </tr>
        <tr>
            <td width="150px">Start Date:</td>
            <td><input type="text" name="txtStartDate" class="datepicker" value='<?php echo $start_date; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorStartDate;}?></td>
        </tr>
        <tr>
            <td width="150px">End Date:</td>
            <td><input type="text" name="txtEndDate" class="datepicker" value='<?php echo $end_date; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorEndDate;}?></td>
        </tr>
        <tr>
            <td width="150px">Start Time:</td>
            <td><input type="text" name="txtStartTime" value='<?php echo $row['start_time']; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorStartTime;}?></td>
        </tr>
        <tr>
            <td width="150px">End Time:</td>
            <td><input type="text" name="txtEndTime" value='<?php echo $row['end_time']; ?>'><br/><?php if(isset($_POST["editevent"])){ echo $errorEndTime;}?></td>
        </tr>
        <tr>
            <td width="150px">Detail</td>
            <td width="250px"><textarea name="txtDetail"><?php echo $row['detail']; ?></textarea><br/><?php if(isset($_POST["editevent"])){ echo $errorDetail;}?></td>
        </tr>
    </table>
    <input type="submit" id="editEventButton" name="editevent" value="Edit">
    <input type="submit" id="deleteEventButton" name="deleteevent" value="Delete">
</form>

