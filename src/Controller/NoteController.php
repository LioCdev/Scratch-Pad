<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Tag;
use App\Form\NoteType;
use App\Form\TagType;
use App\Repository\NoteRepository;
use App\Repository\TagRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository, TagRepository $tagRepository): Response
    {
        return $this->render('note/index.html.twig', [
            'notes' => $noteRepository->findBy(['userId' => $this->getUser()->getId()]),
            'tags' => $tagRepository->findBy(['userId' => $this->getUser()->getId()])
        ]);
    }

    /**
     * @Route("/tag/{id}", name="note_byTag", methods={"GET"})
     */
    public function noteByTag(Tag $tag, TagRepository $tagRepository ,NoteRepository $noteRepository): Response
    {

        $notesByTag = $tag->getNotes();

        $notes = [];
        foreach ($notesByTag as $noteByTag) {

            if ($noteByTag->getUserId()->getId() === $this->getUser()->getId()) {
                $notes[] = $noteByTag;
            }
        }

        return $this->render('note/noteByTag.html.twig', [
            'notes' => $notes

        ]);
    }

    /**
     * @Route("/new", name="note_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, TagRepository $tagRepository): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        $tag = new Tag();
        $formTag = $this->createForm(TagType::class, $tag);
        $formTag->handleRequest($request);

        $submitDate = new DateTime();

        if ($form->isSubmitted() && $form->isValid()) {

            $tag = $tagRepository->findOneBy(['id' => intval($request->request->get('note')['tags'][0])]);
            $note->addTag($tag);
            $note->setUserId($security->getUser());
            $note->setDate($submitDate->setTimestamp(time()));

            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($formTag->isSubmitted() && $formTag->isValid()) {
            $tag->setUserId($security->getUser());
            
            $entityManager->persist($tag);
            $entityManager->flush();

            // return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('note/new.html.twig', [
            'note' => $note,
            'tag' => $tag,
            'form' => $form,
            'formTag'=> $formTag,
        ]);
    }

    /**
     * @Route("/{id}", name="note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('note/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"POST"})
     */
    public function delete(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
    }
}
