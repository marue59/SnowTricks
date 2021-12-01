//picture
const addItem = (e) => {
    // cibler CollectionHolder = collection de picture
    // et recupérer les données de data-collection dans la vue
    const collectionHolder = document.querySelector(e.currentTarget.dataset.collection);

    // récuperer le prototype
    // remplacer le prototype par l'index
    collectionHolder.innerHTML += collectionHolder
    .dataset
    .prototype
    .replace(
        /__name__/g, 
        collectionHolder.dataset.index
        );

    collectionHolder.dataset.index ++ ;

  };
document.querySelectorAll('.btn-new').forEach(btn=> btn.addEventListener('click', addItem));


