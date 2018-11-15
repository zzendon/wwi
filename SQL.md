## Color update
```
INSERT INTO colors (ColorID, ColorName, LastEditedBy, ValidFrom, ValidTo)
values (37, 'Green', 1, '2013-01-01 00:00:00', '9999-12-31 23:59:59');
UPDATE stockitems
SET ColorID = 37 
WHERE StockItemName LIKE '%(Green)%';
```
## Review
Hier kun je terug vinden hoe je reviews in je database kan krijgen.
## Review Table
```
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `review` (
  `ReviewId` int(45) NOT NULL,
  `StockItemID` int(11) NOT NULL,
  `Tekst` varchar(45) DEFAULT NULL,
  `Stars` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

ALTER TABLE `review`
  MODIFY `review_id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
```
### Random reviews genereren.
```
<?php
include "php/connectdb.php";

$connection = getConnection();

$reviews = array("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum",
"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, 
totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. ",
"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, 
consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. ",
"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, 
consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. ",
"Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? 
Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?",
"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness."
);

$pro = $connection->prepare("SELECT distinct StockItemId FROM stockitems");
$pro->execute();

while ($row = $pro->fetch()) {
    $stockItemId = $row["StockItemId"];
    $review = $reviews[random_int(0, count($reviews)  - 1 )];
    $star = random_int(1,5);
    $rev = $connection->prepare("INSERT INTO review (StockItemID, Tekst, Stars) VALUES('$stockItemId', '$review', '$star')");
    $rev->execute();
    print_r($rev->errorInfo());
}
```

# Customer Table
```
CREATE TABLE `customer` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(40) NOT NULL,
  `LastName` varchar(40) NOT NULL,
  `Address1` varchar(40) NOT NULL,
  `Address2` varchar(40) NOT NULL,
  `Language` varchar(40) NOT NULL,
  `Country` varchar(40) NOT NULL,
  `PostalCode` varchar(40) NOT NULL,
  `City` varchar(40) NOT NULL,
  `PhoneNumber` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `customer`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `customer`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
```
