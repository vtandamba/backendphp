import React, { useState, useEffect } from 'react';

function UserList() {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    // Fonction pour récupérer la liste des utilisateurs depuis l'API
    const fetchUsers = async () => {
      try {
        const response = await fetch('https://vtandamb.lpmiaw.univ-lr.fr/PHP/backendphp/back/api.php');
        if (!response.ok) {
          throw new Error('Erreur lors de la récupération des utilisateurs');
        }
        const data = await response.json();
        setUsers(data);
      } catch (error) {
        console.error(error);
      }
    };

    // Appel de la fonction pour récupérer les utilisateurs au chargement du composant
    fetchUsers();
  }, []); // Le tableau vide en tant que second argument signifie que cette fonction ne doit être appelée qu'une seule fois au montage du composant

  return (
    <div>
      <h2>Liste des utilisateurs</h2>
      <ul>
        {users.map(user => (
          <li key={user.id}>
            {user.name} - {user.email}
          </li>
        ))}
      </ul>
    </div>
  );
}

export default UserList;
