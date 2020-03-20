# Project 2: Design Journey

Be clear and concise in your writing. Bullets points are encouraged.

**Everything, including images, must be visible in VS Code's Markdown Preview.** If it's not visible in Markdown Preview, then we won't grade it.

## Catalog (Milestone 1)

### Describe your Catalog (Milestone 1)
> What will your collection be about? What types of attributes will you keep track of for the *things* in your catalog? 1-2 sentences.

I will be making a catalog of economy sedans sold in the United States.
model
manufacturer
base_msrp
city_mpg
last_year_of_redesign

### Target Audience(s) (Milestone 1)
> Tell us about your target audience(s).

My target audience is new car buyers who are budget concious. base_msrp is the absolute lowest you can pay for a car model (without bargaining at all), city_mpg is the worst case scenario for fuel consumption, and last_year_of_redesign is important for new car buyers because it may help determine how long your car looks "new."


### Design Patterns (Milestone 1)
> Review some existing catalog that are similar to yours. List the catalog's you reviewed here. Write a small reflection on how you might use the design patterns you identified in your review in your own catalog.

https://www.edmunds.com/sedan/
https://www.kbb.com/sedan/
https://www.consumerreports.org/search/?query=Sedans

All these have all of the info that will be included in my catalog, but these websites have A LOT of extra info that may not be relevant to economy buyers. Most of the price ranges include options that are only available on more expensive models. A lot of the info is also behind quite a few clicks--my catalog will have no clicks to view info on these cars.

Edmunds and consumer reports are definitely feel like galleries as much as they do catalogs.

My catalog will also have filter fields for all of the 5 fields.


## Design & Planning (Milestone 2)

## Design Process (Milestone 2)
> Document your design process. Show us the evolution of your design from your first idea (sketch) to design you wish to implement (sketch). Show us the process you used to organize content and plan the navigation, if applicable.

Here is just an initial design
![Image of Form](/documents/first.jpeg)

I realized that there needed to be both Search and Add functionality
![Image of Form](/documents/final.jpeg)
> Label all images. All labels must be visible in VS Code's Markdown Preview.
> Clearly label the final design.

This is the final design
![Image of Form](/documents/final.jpeg)


## Partials (Milestone 2)
> If you have any partials, plan them here.

Each of these "cards" will display a row of the database. A php function will produce these partials in a grid-auto-layout


## Database Schema (Milestone 2)
> Describe the structure of your database. You may use words or a picture. A bulleted list is probably the simplest way to do this. Make sure you include constraints for each field.

Table: sedans(
    id: INTEGER {PK, U, NOT, AI}
    model: TEXT {NOT}
    manufacturer: TEXT {NOT}
    base_msrp: INTEGER {NOT}
    city_mpg: INTEGER {NOT}
    last_year_of_redesign: INTEGER {NOT}
)

## Database Query Plan (Milestone 2)
> Plan your database queries. You may use natural language, pseudocode, or SQL.]

1. All records

    ```
    SELECT * FROM sedans;
    ```

2. Search records

    ```
    SELECT * FROM sedans WHERE $seach_var = "$search_entry";
    ```

3. Insert record

    ```
    INSERT INTO sedans (id, model, manufacturer, base_msrp, city_mpg, last_year_of_redesign) values ( $var1, $var2, $var3, $var4, $var5)
    ```


## Code Planning (Milestone 2)
> Plan any PHP code you'll need here.

function print_card($jsonObj)
{
  $json = json_decode($jsonObj, TRUE);
  include("includes/card.php");
}


      foreach ($jsonArray as $s) {
        print_card($s);
      }


$db = open_sqlite_db("PATH");

$sql = "SELECT * FROM sedans;";
      $result = exec_sql_query($db, $sql);
      $records = $result->fetchAll();

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}

# Reflection (Final Submission)
> Take this time to reflect on what you learned during this assignment. How have you improved since Project 1? What things did you have trouble with?

I pulled the car information from https://www.edmunds.com/sedan/

I had A LOT of trouble with the if statement and searching by minimum msrp. I needed to use elseif after the first if because everything was falling to the else statement.

I changed up my design to center the forms, here is my design change below

![Image of Form](/documents/centered.jpg)
