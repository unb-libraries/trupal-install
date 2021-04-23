<?php

namespace Trupal\Composer\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\Loader\InvalidPackageException;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * Installer for Trupal extensions.
 *
 * @package Trupal\Composer\Installer
 */
class TrupalInstaller extends LibraryInstaller {

  /**
   * @var \Composer\Package\PackageInterface
   */
  protected $trupal;

  /**
   * Find the Trupal package.
   *
   * @return \Composer\Package\PackageInterface|null
   */
  protected function getTrupalPackage() {
    if (!isset($this->trupal)) {
      $this->trupal = $this->composer()
        ->getRepositoryManager()
        ->findPackage('trupal/trupal', '*');
    }
    return $this->trupal;
  }

  /**
   * Get composer.
   *
   * @return \Composer\Composer
   */
  protected function composer() {
    return $this->composer;
  }

  /**
   * {@inheritDoc}
   *
   * @throws \Composer\Package\Loader\InvalidPackageException
   */
  public function install(InstalledRepositoryInterface $repo, PackageInterface $package) {
    if (!$this->getTrupalPackage()) {
      throw new InvalidPackageException(['Trupal must be installed in order to install Trupal extensions.'], [], []);
    }
    return parent::install($repo, $package);
  }

  /**
   * {@inheritDoc}
   */
  public function getInstallPath(PackageInterface $package) {
    $trupal = $this->getTrupalPackage();
    $trupal_root = parent::getInstallPath($trupal);
    $exploded_package_name = explode('/', $package->getPrettyName());
    return implode(DIRECTORY_SEPARATOR, [
      $trupal_root,
      'extend',
      array_pop($exploded_package_name)
    ]);
  }

  /**
   * {@inheritDoc}
   */
  public function supports($packageType) {
    return $packageType === 'trupal-extension';
  }

}
