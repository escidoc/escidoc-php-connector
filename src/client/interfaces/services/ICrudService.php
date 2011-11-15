<?php
namespace escidoc\services;

/**
 * Interface for HandlerClients, which support all CRUD operations for their resources.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface ICrudService extends ICreateService, IRetrieveService, IUpdateService, IDeleteService {

}
?>