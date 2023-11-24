<?php

namespace App\Controller;


use App\Entity\Profesor;
use App\Repository\ProfesorRepository;
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



class ProfesorController extends AbstractController
{

    private ProfesorRepository $objRepository;
    private EntityManagerInterface $em;
    private $profesorRepository;


    public function __construct(ProfesorRepository $profesorRepository, EntityManagerInterface $em)
    {
        $this->objRepository = $profesorRepository;
        $this->em = $em;
    }

    #[Route('/api/profesor/{id}', methods: ['GET', 'HEAD'])]
    public function show(int $id): JsonResponse
    {
        $profesores = $this->objRepository->find($id);
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => $profesores->getId(),
                    'nombre' => $profesores->getNombre(),
                    'apellido' => $profesores->getApellido(),
                    'fecha_nacimiento' => $profesores->getFechaNacimiento(),
                    'direccion' => $profesores->getDireccion(),
                    'telefono' => $profesores->getTelefono(),
                    'codigo_postal' => $profesores->getCodigoPostal(),
                    'email' => $profesores->getEmail(),
                    'especialista' => $profesores->getEspecialista()
                ]
            ]
        ]);
        return $response;
    }
    #[Route('/api/profesor/', methods: ['POST'])]
    public function createProfesor(Request $request): JsonResponse  
    {
        $profesores = new profesor();
        $response = new JsonResponse();

        $objData = json_decode($request->getContent());

        if (empty($objData->nombre)) {
            $response->setData([
                'success' => true,
                'data' => 'nombre no puede estar vacio'
            ]);
        }
        $profesores->setNombre($objData->nombre);
        $profesores->setApellido($objData->apellido);
        $profesores->setFechaNacimiento(DateTime::createFromFormat('Y-m-d', $objData->fecha_nacimiento));
        $profesores->setDireccion($objData->apellido);
        $profesores->setTelefono(152351325);
        $profesores->setCodigoPostal(151515);
        $profesores->setEmail($objData->apellido);
        $profesores->setEspecialista($objData->apellido);
        $this->em->persist($profesores);
        $this->em->flush();
        $response->setData([
            'success' => true,
            'data' => [
                [
                    'id' => $profesores->getId(),
                    'nombre' => $profesores->getNombre(),
                    'apellido' => $profesores->getApellido(),
                    'fecha_nacimiento' => $profesores->getFechaNacimiento(),
                    'direccion' => $profesores->getDireccion(),
                    'telefono' => $profesores->getTelefono(),
                    'codigo_postal' => $profesores->getCodigoPostal(),
                    'email' => $profesores->getEmail(),
                    'especialista' => $profesores->getEspecialista()
                ]
            ]
        ]);
        return $response;
    }
    

    #[Route('/api/profesor/{id}', methods: ['DELETE'])]
    public function delete(int $id, Request $request, EntityManagerInterface $em)
    {
        $response = new JsonResponse();
        $profesores = $this->objRepository->find($id);

        $this->em->remove($profesores);
        $this->em->flush();

        $response->setData([
            'success' => true,
            'echo' => "Profesor ha sido eliminado"
            ]);
            return $response;
    }


    #[Route('/api/profesor/{id}', methods: ['PATCH'])]
    public function update(int $id, Request $request,ProfesorRepository $profesorRepository,
    EntityManagerInterface $em): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $fecha__nacimiento = $data['fecha_nacimiento'];
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];
        $codigo_postal = $data['codigo_postal'];
        $email = $data['email'];
        $especialidad = $data['especialidad'];
        

        $response = new JsonResponse();
  
        $objRepository = $this->profesorRepository->find($id);
        $fecha_nacimiento = new \DateTime($fecha__nacimiento);
        $objRepository->setNombre((String)$nombre);
        $objRepository->setApellido((String)$apellido);
        $objRepository->setFechaNacimiento($fecha_nacimiento);
        $objRepository->setDireccion((String)$direccion);
        $objRepository->setTelefono((int)$telefono);
        $objRepository->setCodigoPostal((int)$codigo_postal);
        $objRepository->setEmail((String)$email);
        $objRepository->setEspecialidad((String)$especialidad);

        $em->persist($objRepository);
        $em->flush();
        $response->setData([
            'success' => true,
            'data' => [
                $this->objRepository->dataProfesor($objRepository)
        ]
        ]);
        return $response;
    }
}

