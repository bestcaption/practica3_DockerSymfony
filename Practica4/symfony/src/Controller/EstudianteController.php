<?php

namespace App\Controller;


use App\Entity\Estudiante;
use App\Repository\EstudianteRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Doctrine\Persistence\ManagerRegistry;
use finfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class EstudianteController extends AbstractController
{

    private EstudianteRepository $objRepository;
    private EntityManagerInterface $em;

    public function __construct(EstudianteRepository $estudianteRepository,EntityManagerInterface $em) 
    {
        $this->objRepository = $estudianteRepository;
        $this->em = $em;
    }

    #[Route('/api/estudiante/{id}', methods: ['GET', 'HEAD'])]
    public function show(int $id): JsonResponse
    {
        $estudiantes= $this->objRepository->find($id);
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => $estudiantes->getId(),
                    'nombre' => $estudiantes->getNombre(),
                    'apellido' => $estudiantes->getApellido(),
                    'fecha_nacimiento' => $estudiantes->getFechaNacimiento(),
                    'direccion' => $estudiantes->getDireccion(),
                    'telefono' => $estudiantes->getTelefono(),
                    'codigo_postal' => $estudiantes->getCodigoPostal(),
                    'email' => $estudiantes->getEmail()
                ]
            ]
        ]);
        return $response;
    }
    #[Route('/api/estudiante/', methods: ['POST'])]
    public function createProfesor(Request $request): JsonResponse
    {
        $estudiantes = new estudiante();
        $response = new JsonResponse();

        $objData = json_decode($request->getContent());

        if (empty($objData->nombre)) {
            $response->setData([
                'success' => true,
                'data' => 'nombre no puede estar vacio'
            ]);
        }
        $estudiantes->setNombre($objData->nombre);
        $estudiantes->setApellido($objData->apellido);
        $estudiantes->setFechaNacimiento(DateTime::createFromFormat('Y-m-d', $objData->fecha_nacimiento));
        $estudiantes->setDireccion($objData->apellido);
        $estudiantes->setTelefono(152351325);
        $estudiantes->setCodigoPostal(151515);
        $estudiantes->setEmail($objData->apellido);
        $this->em->persist($estudiantes);
        $this->em->flush();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => $estudiantes->getId(),
                    'nombre' => $estudiantes->getNombre(),
                    'apellido' => $estudiantes->getApellido(),
                    'fecha_nacimiento' => $estudiantes->getFechaNacimiento(),
                    'direccion' => $estudiantes->getDireccion(),
                    'telefono' => $estudiantes->getTelefono(),
                    'codigo_postal' => $estudiantes->getCodigoPostal(),
                    'email' => $estudiantes->getEmail(),
                ]
            ]
        ]);
        return $response;
    }
    #[Route('/api/estudiante/{id}', methods: ['DELETE'])]
    public function delete(int $id, Request $request, EntityManagerInterface $em)
    {
        $response = new JsonResponse();
        $estudiantes = $this->objRepository->find($id);

        $this->em->remove($estudiantes);
        $this->em->flush();

        $response->setData([
            'success' => true,
            'echo' => "Estudiante ha sido eliminado"
            ]);
            return $response;
    }
}