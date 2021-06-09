<?php

namespace App\Form;

use App\Entity\AppLayoutSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use App\Service\AppServices;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppLayoutSettingsType extends AbstractType {

    private $services;
    private $params;

    public function __construct(AppServices $services, ParameterBagInterface $params) {
        $this->services = $services;
        $this->params = $params;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $pages = [];
        $availableLocales = array_values(array_filter(explode("|", $this->params->get('available_locales'))));
        $availableLocales = array_combine(array_values($availableLocales), array_values($availableLocales));
        foreach ($this->services->getPages(array())->getQuery()->getResult() as $page) {
            $pages[$page->getTitle()] = $page->getSlug();
        }

        $builder
                ->add('app_environment', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'App Environment',
                    'choices' => ['Production' => 'prod', 'Development' => 'dev'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'Development environment is used for development purposes only',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('app_debug', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'App Debugging',
                    'choices' => ['Enable' => '1', 'Disable' => '0'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'Enable to display stacktraces on error pages or if cache files should be dynamically rebuilt on each request',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('app_secret', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'App Secret',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'This is a string that should be unique to your application and it is commonly used to add more entropy to security related operations'
                ])
                ->add('maintenance_mode', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Maintenance mode',
                    'choices' => ['Disabled' => 0, 'Enabled' => 1],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'help' => 'Enable maintenance mode to display a maintenance page for all users but the users who are granted the ROLE_ADMINISTRATOR role, if you lost your session, you can edit the MAINTENANCE_MODE parameter directly in the .env file',
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('maintenance_mode_custom_message', TextareaType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Maintenance mode custom message',
                ])
                ->add('date_format', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Date and time format',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'Project wide date and time format, follow this link for a list of supported characters: https://unicode-org.github.io/icu/userguide/format_parse/datetime/ . Please make sure to keep the double quotes " " around the format string'
                ])
                ->add('date_format_simple', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Alternative date and time format',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'Used in some specific cases, follow this link for a list of supported characters: https://www.php.net/manual/en/datetime.format.php . Please make sure to keep the double quotes " " around the format string'
                ])
                ->add('date_format_date_only', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Date only format',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'Used in some specific cases, follow this link for a list of supported characters: https://www.php.net/manual/en/datetime.format.php . Please make sure to keep the double quotes " " around the format string'
                ])
                ->add('date_timezone', TimezoneType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'label' => 'Timezone',
                    'constraints' => array(
                        new NotBlank()
                    )
                ])
                ->add('default_locale', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'choices' => $availableLocales,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'label' => 'Default language',
                    'constraints' => array(
                        new NotBlank()
                    )
                ])
                ->add('app_locales', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => $availableLocales,
                    'label' => 'Available languages',
                    'constraints' => array(
                        new Count(['min' => 0]),
                    )
                ])
                ->add('website_name', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Website name',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_slug', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Website slug',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'Enter the chosen website name with no spaces and no uppercase characters (for SEO purposes)'
                ])
                ->add('website_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Website url',
                    'constraints' => array(
                        new NotBlank()
                    ),
                    'help' => 'Enter the full website url'
                ])
                ->add('website_root_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Website root url',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_description_en', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_description_fr', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_description_es', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_description_ar', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_keywords_en', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'SEO keywords',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_keywords_fr', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_keywords_es', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('website_keywords_ar', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => false,
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('contact_email', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Contact email',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('contact_phone', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Contact phone',
                ])
                ->add('contact_fax', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Contact fax',
                ])
                ->add('contact_address', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Contact address',
                ])
                ->add('facebook_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Facebook url',
                ])
                ->add('instagram_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Instagram url',
                ])
                ->add('youtube_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Youtube url',
                ])
                ->add('twitter_url', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Twitter url',
                ])
                ->add('app_layout', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Application layout',
                    'choices' => ['Compact' => 'container', 'Fluid' => 'container-fluid'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('app_theme', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Application theme',
                    'choices' => ['Orange' => 'orange', 'Light blue' => 'lightblue', 'Dark blue' => 'darkblue',
                        'Yellow' => 'yellow', 'Purple' => 'purple', 'Pink' => 'pink', 'Red' => 'red', 'Green' => 'green', 'Dark' => 'dark'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('primary_color', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'Primary color code',
                    'attr' => ['readonly' => true],
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('no_reply_email', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => true,
                    'label' => 'No reply email address',
                    'constraints' => array(
                        new NotBlank()
                    ),
                ])
                ->add('logoFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Logo',
                    'help' => 'Please choose a 200x50 image size to ensure compatibility with the website design',
                    'translation_domain' => 'messages'
                ])
                ->add('faviconFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Favicon',
                    'help' => 'We recommend a 48x48 image size',
                    'translation_domain' => 'messages'
                ])
                ->add('ogImageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_label' => false,
                    'download_uri' => false,
                    'image_uri' => false,
                    'imagine_pattern' => 'scale',
                    'label' => 'Social media share image',
                    'help' => 'Please choose a 200x200 minimum image size as it is required by Facebook',
                    'translation_domain' => 'messages'
                ])
                ->add('show_back_to_top_button', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the back to top button',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_terms_of_service_page', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the terms of service page link',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('terms_of_service_page_slug', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Terms of service page slug',
                    'choices' => $pages,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_privacy_policy_page', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the privacy policy page link',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('privacy_policy_page_slug', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Privacy policy page slug',
                    'choices' => $pages,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_cookie_policy_page', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the cookie policy page link',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('cookie_policy_page_slug', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Cookie policy page slug',
                    'choices' => $pages,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_cookie_policy_bar', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the cookie policy bar at the bottom',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('show_gdpr_compliance_page', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
                    'label' => 'Show the GDPR compliance page link',
                    'choices' => ['Yes' => 'yes', 'No' => 'no'],
                    'label_attr' => ['class' => 'radio-custom radio-inline'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('gdpr_compliance_page_slug', ChoiceType::class, [
                    'mapped' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Gdpr compliance page slug',
                    'choices' => $pages,
                    'attr' => ['class' => 'select2', 'data-sort-options' => '1'],
                    'constraints' => array(
                        new NotNull()
                    ),
                ])
                ->add('custom_css', TextareaType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Custom css',
                    'attr' => ['rows' => '15']
                ])
                ->add('google_analytics_code', TextType::class, [
                    'purify_html' => true,
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Google analytics Tracking ID',
                    'help' => 'e.g. UA-000000-2'
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Save',
                    'attr' => ['class' => 'btn btn-primary'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => AppLayoutSettings::class,
            'validation_groups' => ['create', 'update']
        ]);
    }

}
