<?php

namespace Trupal\Composer\Installer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Plugin installer for Trupal packages.
 *
 * @package Trupal\Composer\Installer
 */
class PluginInstaller implements PluginInterface {

  /**
   * The installer.
   *
   * @var \Composer\Installer\InstallerInterface
   */
  private $installer;

  /**
   * Get the installer.
   *
   * @return \Composer\Installer\InstallerInterface
   *   An installer.
   */
  private function getInstaller() {
    return $this->installer;
  }

  /**
   * {@inheritDoc}
   */
  public function activate(Composer $composer, IOInterface $io) {
    $this->installer = new TrupalInstaller($io, $composer, 'trupal-extension');
    $composer->getInstallationManager()->addInstaller($this->installer);
  }

  /**
   * {@inheritDoc}
   */
  public function deactivate(Composer $composer, IOInterface $io) {
    $composer->getInstallationManager()
      ->removeInstaller($this->getInstaller());
  }

  /**
   * {@inheritDoc}
   */
  public function uninstall(Composer $composer, IOInterface $io) {
  }

}
