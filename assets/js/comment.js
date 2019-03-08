$(function() {
    //Au clic sur <button type="button">modifier</button> sur un commentaire
   $('.modifyContent').click(function() {
       //On stocke le contenu du commentaire dans une variable
       //$(this) designe le <button type="button">modifier</button> sur lequel on a cliqué,
       // parent designe la div du commentaire a modifier, 
       //find('.content') designe le contenu du commentaire a modifier
       //text() designe le contenu du de la balise <p class=content>
      var commentContent = $(this).parent().find('.content').text();
      //On recupere la classe du commentaire dans le champ hidden
      var commentId = $(this).parent().find( '.commentId').val();
      $(this).parent().find( '.commentId').remove();
      //On remplace le contenu du commentaire par un formulaire pour envoyer le nouveau contenu modifié 
      //en lui creant un champ hidden avec l'id du commentaire
      $(this).parent().find('.content').replaceWith('<form method="post" action="#">\n\
<textarea class="content" name="content"></textarea>\n\
<input type="hidden"  class="commentId "name="commentId" value="' + commentId + '">\n\
<button class=""btn btn-primary" type="submit" name="modifyComment">Modifier !</button></form>');
      //On met le contenu dans le textarea
      $(this).parent().find('.content').val(commentContent);
      //On retire notre lien "modifier"
      $(this).remove();
   });
});

