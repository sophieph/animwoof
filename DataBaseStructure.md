
    animal :
        - id 
        - nom (patric, sophia, nass, ...)
        - is_adopted (true/false)
        - sexe (M,F,Hermaprhodite)
        - description
        - date (naissance, created_at, adopted_date, update_at)
        - espece_id (espece->id)

    espece
        - id
        - nom (chien, chat, serpent, elephant, girafe, ...)


    product
        - id
        - nom
        - price
        - description
        - quantity
        - is_active
        - created_at

    product_category
	    - produit_id (product -> id)
	    - category_id (category->id)

    order
        - id
	    - user_id (user->id)
	    - created_at


    order_product
	    - order_id(order -> id)
	    - product_id (product -> id)
	    - prix_unitaire -> product_price
	    - quantity

	category
		- id
		- nom

	
	donnations
		- id
		- date	
		- donnateur (user->id, anonymous)
		- amount (€, $ ?, £?)

	user
		- id
		- username
		- role_id (role->id)
		- mail
		- created_at
	

	role
		- id
		- nom	

