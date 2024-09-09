CREATE TABLE `expenses` (
  `expense_id` int(20) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  `expense` int(20) NOT NULL,
  `expensedate` varchar(15) NOT NULL,
  `expensecategory` varchar(50) NOT NULL
);

CREATE TABLE `expense_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
);

INSERT INTO `expense_categories` (`category_id`, `category_name`) VALUES
(1, 'Medicine'),
(2, 'Food'),
(3, 'Bills & Recharges'),
(4, 'Entertainment'),
(5, 'Clothings'),
(6, 'Rent'),
(7, 'Household Items'),
(8, 'Others');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
);

ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `expenses`
  MODIFY `expense_id` int(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `expense_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
