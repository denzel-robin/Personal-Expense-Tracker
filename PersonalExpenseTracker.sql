CREATE TABLE `expenses` (
  `expense_id` int NOT NULL,
  `user_id` varchar NOT NULL,
  `expense` int NOT NULL,
  `expensedate` varchar NOT NULL,
  `category_id` int NOT NULL
);

CREATE TABLE `expense_categories` (
  `category_id` int NOT NULL,
  `category_name` varchar NOT NULL
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
  `user_id` int NOT NULL,
  `firstname` varchar NOT NULL,
  `lastname` varchar NOT NULL,
  `email` varchar NOT NULL,
  `password` varchar NOT NULL
);

ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`category_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `expenses`
  MODIFY `expense_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `expense_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;
