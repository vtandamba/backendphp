import React, { useState } from 'react';

const UserForm = () => {
  const [userData, setUserData] = useState({ name: '', email: '' });

  const handleSubmit = (event) => {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire

    const requestOptions = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(userData)
    };

    // Envoyer la requête POST à l'API
    fetch('https://vtandamb.lpmiaw.univ-lr.fr/PHP/backendphp/back/api.php', requestOptions)
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors de la création de l\'utilisateur');
        }
        // Vérifier si la réponse contient des données avant de la traiter comme JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json(); // Traiter la réponse comme JSON
        } else {
          console.log('Utilisateur créé avec succès');
          return; // Sortir de la fonction
        }
      })
      .then(data => {
        if (data) { // Vérifier si des données ont été renvoyées
          console.log('Utilisateur créé avec succès:', data);

          // Envoi des données à l'API pour les persister dans la base de données
          const persistDataRequestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data) // Utilisez les données renvoyées par l'API précédente
          };

          fetch('https://vtandamb.lpmiaw.univ-lr.fr/PHP/backendphp/back/api.php', persistDataRequestOptions)
            .then(response => {
              if (!response.ok) {
                throw new Error('Erreur lors de la persistance des données dans la base de données');
              }
              return response.json();
            })
            .then(data => {
              console.log('Données persistées avec succès:', data);
            })
            .catch(error => {
              console.error('Erreur lors de la persistance des données:', error);
            });
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
      });
  }


  const handleChange = (event) => {
    const { name, value } = event.target;
    setUserData(prevState => ({
      ...prevState,
      [name]: value
    }));
  }

  return (
    <div>
      <h2>Ajouter un utilisateur</h2>
      <form onSubmit={handleSubmit}>
        <label htmlFor="name">Name :</label>
        <input type='text' id='name' name='name' value={userData.name} onChange={handleChange} />
        <br />
        <label htmlFor="email">Email :</label>
        <input type='email' id='email' name='email' value={userData.email} onChange={handleChange} />
        <br />
        <button type='submit'>Envoyer</button>
      </form>
    </div>
  );
}

export default UserForm;
