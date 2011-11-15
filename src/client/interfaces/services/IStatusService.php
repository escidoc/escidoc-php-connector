<?php
namespace escidoc\services;

/**
 * Interface for HandlerClients, which support resources, whose state can be changed to all existing values.
 *
 * Values like <i>opened, closed, activated & deactivated</i> are excluded from this set, because these are special statuses for special resources.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IStatusService extends IReleaseService, IReviseService, ISubmitService, IWithdrawService {

}
?>